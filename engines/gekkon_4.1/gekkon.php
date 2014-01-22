<?php

//version 4.2
class Gekkon {

    var $version = 4.2;
    var $bin_path;
    var $tpl_path;
    var $gekkon_path;
    var $data;

    function __construct($tpl_base_path, $bin_path, $tpl_path)
    {
        $this->bin_path = $bin_path;
        $this->tpl_base_path = $tpl_base_path;
        $this->tpl_path = $tpl_path;
        $this->gekkon_path = dirname(__file__).'/';
        $this->compiler = false;
        $this->display_errors = ini_get('display_errors') == 'on';
        $this->tpl_name = '';
        $this->compiler_settings = array();
    }

    function register($name, &$data)
    {
        $this->data[$name] = &$data;
    }

    function assign($name, $data)
    {
        $this->data[$name] = $data;
    }

    function display($tpl_name)
    {
        $tpl_time = 0;
        if(is_file($tpl_file = $this->full_tpl_path($tpl_name)))
                $tpl_time = filemtime($tpl_file);

        $bin_time = 0;
        if(is_file($bin_file = $this->full_bin_path($tpl_name)))
                $bin_time = filemtime($bin_file);

        if($tpl_time == 0)
                return $this->error('Template '.$tpl_name.' cannot be found at '.$tpl_file,
                    'gekkon');

        if($bin_time < $tpl_time)
        {
            $this->clear_cache($tpl_name);
            if(!$this->compile($tpl_name))
                    return $this->error('Cannot compile '.$tpl_name, 'gekkon');
        }
        $tpl_name_save = $this->tpl_name;
        $this->tpl_name = $tpl_name;
        $fn_nme = $this->fn_name($tpl_name);

        if(!function_exists($fn_nme))
        {
            include_once $bin_file;
        }
        $fn_nme($this);
        $this->tpl_name = $tpl_name_save;
    }

    function get_display($tpl_name)
    {
        ob_start();
        $this->display($tpl_name);
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    function fn_name($tpl_name)
    {
        return 'gekkon_'.strtr($this->tpl_path.$tpl_name, '/!.', '___');
    }

    function cache_dir($tpl_name)
    {
        return dirname($this->full_bin_path($tpl_name)).'/cache/';
    }

    function cache_file($tpl_name, $id = '')
    {
        $name = md5(serialize($id).$tpl_name);
        return $name[0].$name[1].'/'.$name;
    }

    function clear_cache($tpl_name, $id = '')
    {
        if($id !== '')
        {
            $cache_file = $this->cache_dir($tpl_name).
                $this->cache_file($tpl_name, $id);

            if(is_file($cache_file)) unlink($cache_file);
            return;
        }
        else $this->clear_dir(dirname($this->full_bin_path($tpl_name)).'/');
    }

    function compile($tpl_name)
    {
        if(!$this->compiler)
        {
            include_once 'compiler_settings.php';
            Gekkon::include_dir($this->gekkon_path.'compiler');
            $this->compiler_settings = $compiler_settings;
            $this->compiler = new GekkonCompiler($this);
        }
        return $this->compiler->compile($tpl_name);
    }

    function full_tpl_path($tpl_name)
    {
        return $this->tpl_base_path.$this->tpl_path.$tpl_name;
    }

    function full_bin_path($tpl_name)
    {
        if(($t = strrpos($tpl_name, '_')) !== false)
        {
            $tpl_name = $bin_name = basename(substr($tpl_name, 0, $t)).'.tpl';
            if(($t = strrpos($tpl_name, '_')) !== false)
                    $tpl_name = $bin_name = substr($tpl_name, 0, $t).'.tpl';
        }
        else $bin_name = basename($tpl_name);

        $bin_path = $this->bin_path.abs(crc32($this->tpl_path.$tpl_name)).'/';

        return $bin_path.$bin_name.'.php';
    }

    function error($msg, $object = false)
    {
        $message = 'Gekkon:';
        if($object !== false) $message .= ' ['.$object.']';
        $message .= ' '.nl2br($msg."\n");

        if($this->display_errors)
                echo '<div class="gekkon_error">'.$message.'</div>';

        error_log(trim(strip_tags($message)));
        return false;
    }

    function include_dir($path)
    {
        $path = rtrim($path, '/');
        $dirs = array();
        if(is_dir($path))
        {
            $files = scandir($path);
            foreach($files as $file)
            {
                if($file[0] != '.')
                {
                    if(is_dir($path.'/'.$file)) $dirs[] = $path.'/'.$file;
                    else
                    {
                        $to_include = $path.'/'.$file;
                        if(strtolower(strrchr($to_include, '.')) === '.php')
                        {
                            include_once $to_include;
                        }
                    }
                }
            }
            foreach($dirs as $dir) Gekkon::include_dir($dir);
        }
    }

    function clear_dir($path)
    {
        $path = rtrim($path, '/').'/';
        if(is_dir($path) && $dh = opendir($path))
        {
            while(($file = readdir($dh)) !== false)
            {
                if($file[0] != '.')
                {
                    if(is_dir($path.$file))
                    {
                        Gekkon::clear_dir($path.$file.'/');
                        rmdir($path.$file);
                    }
                    else unlink($path.$file);
                }
            }
            closedir($dh);
        }
    }

    function create_dir($path)
    {
        $path = rtrim($path, '/');
        if(!is_dir($path))
        {
            $parent = dirname($path);
            Gekkon::create_dir($parent);
            mkdir($path);
        }
    }

}

//end of class -----------------------------------------------------------------

