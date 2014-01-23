<?php

//version 2.1
class GekkonCompiler {

    function __construct(&$gekkon)
    {
        $this->errors = array();
        $this->gekkon = $gekkon;
        $this->tpl_name = '';
        $this->uid = 0;
        $this->exp_compiler = new GekkonExpCompiler($this);
        $this->init();
    }

    function init()
    {
        $this->tag_systems = array();
        $tokens = array();
        $tag_system_map = array();
        foreach($this->gekkon->compiler_settings['tag_systems'] as $sys => $data)
        {
            $class_name = 'gekkon_tag_sys_'.$sys;
            if(class_exists($class_name))
            {
                $this->tag_systems[$sys] = new $class_name($this, $data);
                $tokens[$data['open']][$data['close']] = preg_quote($data['close'],
                    '/');
                $tag_system_map[$data['open']][$data['close']][] = $sys;
            }
        }
        $open_tokens = array();
        $close_tokens = array();
        foreach($tokens as $open => $close)
        {
            $open_tokens[$open] = preg_quote($open, '/');
            rsort($close); // Longer token goes first
            $close_tokens[$open] = implode('|', $close);
        }

        rsort($open_tokens);
        $this->open_tokens = implode('|', $open_tokens);
        $this->tag_system_map = $tag_system_map;
        $this->close_tokens = $close_tokens;
    }

    function compile($tpl_name)
    {
        $this->error = array();
        $tpl_file = $this->gekkon->full_tpl_path($tpl_name);
        if(!is_file($tpl_file))
        {
            $this->error('Cannot find '.$tpl_file, 'gekkon_compiller');
            return false;
        }

        $this->file_list = array();
        $this->bin_file = $this->gekkon->full_bin_path($tpl_name);

        $this->get_file_list();

        $rez_data = "<?php\n";
        $rez_flag = true;

        if(!is_dir($t = dirname($this->bin_file))) mkdir($t, 0777);

        foreach($this->file_list as $tpl)
        {
            if(($t = $this->compile_file($tpl)) !== false) $rez_data .= $t;
            else $rez_flag = false;
        }
        file_put_contents($this->bin_file, $rez_data);
        return $rez_flag;
    }

    function compile_file($tpl_name)
    {
        $this->tpl_name = $tpl_name;
        $full_tpl_path = $this->gekkon->full_tpl_path($tpl_name);
        return "\nfunction ".$this->gekkon->fn_name($tpl_name)."(&\$gekkon){\n".
            '// Template file: '.$full_tpl_path."\n".
            "\$_gkn_data=&\$gekkon->data;".
            $this->compile_str(file_get_contents($full_tpl_path)).
            "}\n";
        $this->tpl_name = '';
    }

    function compile_str($_str, $parent = false)
    {
        if($parent === false)
        {
            $parent = new gekkon_base_tag($this);
            $parent->line = 1;
            $parent->system = 'root';
            $parent->parent = false;
        }
        $data = $this->parse_str($_str, $parent);
        $this->flush_errors();
        if($data === false) return false;
        return $this->compile_parsed_str($data);
    }

    function compile_parsed_str($data)
    {
        $rez = '';
        foreach($data as $tag)
        {
            $t = $tag->compile($this);
            if($t !== false) $rez.=$t;
            else $this->flush_errors();
        }
        return $rez;
    }

    function parse_str($_str, $_parent)
    {
        $rez = array();
        $_line = $_parent->line + $_parent->open_lines();

        while($_str != '')
        {
            $_tag = $this->find_tag($_str);
            if($_tag === false)
            {
                $rez[] = new gekkon_tag_static($_str);
                break;
            }

            $_tag->parent = &$_parent;

            if($_tag->open_start > 0)
            {
                $before = new gekkon_tag_static(
                    substr($_str, 0, $_tag->open_start));
                $rez[] = $before;
                //echo $_line, '>', trim($before->content_raw), "\n";
                $_line += $before->total_lines();
                $_str = substr($_str, $before->total_length());
                $_tag->open_start = 0;
            }
            //echo $_line, '>', trim($_tag->open_raw), "\n";
            $_tag->line = $_line;
            $_tag = $this->parse_tag($_tag, $_str);

            $_line += $_tag->total_lines();
            $_str = substr($_str, $_tag->total_length());

            $rez[] = $_tag;
        }
        return $rez;
    }

    function find_tag(&$_str)
    {
        $open_raw = false;
        if(preg_match('/'.$this->open_tokens.'/u', $_str, $preg_data,
                PREG_OFFSET_CAPTURE))
        {
            $open_start_token = $preg_data[0][0];
            $open_start = $preg_data[0][1];
            $open_inner_start = $open_start + mb_strlen($open_start_token);
            if(preg_match('/'.$this->close_tokens[$open_start_token].'/u',
                    $_str, $preg_data, PREG_OFFSET_CAPTURE, $open_start))
            {
                $open_end_token = $preg_data[0][0];
                $open_end = $preg_data[0][1];
                $open_inner_length = $open_end - $open_inner_start;
                $open_length = $open_end - $open_start + mb_strlen($open_end_token);
                $open_raw = substr($_str, $open_inner_start, $open_inner_length);
            }
        }

        if($open_raw === false) return false;

        $_tag = new gekkon_base_tag($this);
        $_tag->open_raw = $open_raw;
        $_tag->start_token = $open_start_token;
        $_tag->end_token = $open_end_token;
        $_tag->open_start = $open_start;
        $_tag->open_length = $open_length;
        return $_tag;
    }

    function parse_tag($_tag, &$_str)
    {
        $possible_systems = $this->tag_system_map[$_tag->start_token][$_tag->end_token];
        foreach($possible_systems as $tag_system)
        {
            $_tag = $this->tag_systems[$tag_system]->try_parse($_tag, $_str);
            if($_tag->system !== '') return $_tag;
        }
        return new gekkon_tag_static(
            $_tag->start_token.$_tag->open_raw.$_tag->end_token);
    }

    function get_file_list($dir = '')
    {
        $list = scandir($this->gekkon->tpl_base_path.$this->gekkon->tpl_path.$dir);
        foreach($list as $file)
        {
            if($file[0] != '.')
            {
                if(is_dir($this->gekkon->tpl_base_path.$this->gekkon->tpl_path.$dir.$file))
                        $this->get_file_list($dir.$file.'/');
                else if(strrchr($file, '.') == '.tpl' && $this->bin_file == $this->gekkon->full_bin_path($dir.$file))
                        $this->file_list[] = $dir.$file;
            }
        }
    }

    function error_in_tag($msg, $_tag)
    {
        return $this->error($msg, 'Tag: '.$_tag->system.':'.$_tag->name,
                $_tag->line);
    }

    function error($msg, $object = false, $line = false)
    {
        $message = '';
        if($object !== false) $message .= '[<b>'.$object.'</b>] ';
        $message .= $msg.' ';

        if($line !== false)
        {
            if($this->tpl_name !== '')
                    $message .= 'in <b>"'.$this->tpl_name.'"</b> ';
            $message .= 'on line '.$line.' ';
        }
        $this->errors[] = $message;
        return false;
    }

    function flush_errors()
    {
        if(count($this->errors) > 0)
        {
            $this->errors = array_reverse($this->errors);
            $message = implode("\n", $this->errors);

            $this->gekkon->error($message, 'Compiler');
            $this->errors = array();
        }
        return false;
    }

    function getUID()//it is a relatively unique id, for uid inside of one template
    {
        return $this->uid++;
    }

    function split_parsed_str($data, $tag_name, $keep_spliter = false)
    {
        $rez = array();
        $key = 0;
        $rez[$key] = array();
        foreach($data as $tag)
        {
            if($tag->name == $tag_name)
            {
                $key++;
                $rez[$key] = array();
                if($keep_spliter) $rez[$key][] = $tag;
            }
            else $rez[$key][] = $tag;
        }
        return $rez;
    }

}

// End Of Class ----------------------------------------------------------------