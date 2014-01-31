<?php

namespace Gekkon;

//version 2.1
class Compiler {

    function __construct(&$gekkon)
    {
        $this->errors = array();
        $this->gekkon = $gekkon;
        $this->tpl_name = '';
        $this->uid = 0;
        $this->exp_compiler = new ExpCompiler($this);
        $this->init();
    }

    function init()
    {
        $this->tag_systems = array();
        $tokens = array();
        $tag_system_map = array();
        foreach($this->gekkon->settings['tag_systems'] as $sys => $data)
        {
            $class_name = __NAMESPACE__.'\TagSys'.$sys;
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

    function compile($template)
    {
        $this->error = array();
        $templateList = $this->gekkon->tplProvider->getAssociated($template);
        $rez = new BinTemplateCodeSet();
        foreach($templateList as $tpl)
        {
            if(($binTpl = $this->compile_one($tpl)) !== false)
                    $rez[$tpl->name] = $binTpl;
        }
        return $rez;
    }

    function compile_one($template)
    {
        $this->binTplCode = new BinTemplateCode($template);
        $this->binTplCode->set($this->compile_str($template->source()));
        return $this->binTplCode;
    }

    function compile_str($_str, $parent = false)
    {
        if($parent === false)
        {
            $parent = new BaseTag($this);
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
            if(($t = $tag->compile($this)) !== false) $rez.=$t;
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
                $rez[] = new Tag_static($_str);
                break;
            }

            $_tag->parent = &$_parent;

            if($_tag->open_start > 0)
            {
                $before = new Tag_static(
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

        $_tag = new BaseTag($this);
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
        return new Tag_static(
                $_tag->start_token.$_tag->open_raw.$_tag->end_token);
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

    function compileOutput($data, $just_code = false)
    {

        if($just_code) $rez = '';
        else $rez = 'echo ';
        if($this->gekkon->settings['auto_escape'])
                $rez.= "htmlspecialchars($data, ENT_QUOTES, 'UTF-8');\n";
        else $rez.= $data.";\n";
        return $rez;
    }

}

// End Of Class ----------------------------------------------------------------

class BinTemplateCode {

    var $blocks = array();
    var $current;
    var $blocks_stack = array();
    var $template;

    function __construct($template)
    {
        $this->template = $template;
        $this->pushBlock('main');
    }

    function pushBlock($name)
    {
        array_push($this->blocks_stack, $name);
        $this->current = $name;
        if(!isset($this->blocks[$name])) $this->blocks[$name] = '';
    }

    function popBlock()
    {
        $this->current = array_pop($this->blocks_stack);
    }

    function add($code)
    {
        $this->blocks[$this->current] .= $code;
    }

    function addBefore($code)
    {
        $this->blocks[$this->current] = $code.$this->blocks[$this->current];
    }

    function set($code)
    {
        $this->blocks[$this->current] = $code;
    }

    function code()
    {
        $rez = "array('blocks'=> array(\n";
        foreach($this->blocks as $name => $block)
        {
            $rez .= "'$name'=>function (\$template,\$gekkon,\$scope){\n".
                    $block.
                    "},\n";
        }
        $info = array(
            'created' => time(),
            'name' => $this->template->name,
            'association' => $this->template->association,
        );
        $rez.="),'info'=>".var_export($info, true).")\n";
        return $rez;
    }

}

// end of class

class BinTemplateCodeSet extends \ArrayObject {

    function code()
    {
        $rez = "array(\n";
        foreach($this as $name => $tplCode)
        {
            $rez .= "'$name'=>".$tplCode->code().',';
        }
        $rez .= ");\n";
        return $rez;
    }

}

