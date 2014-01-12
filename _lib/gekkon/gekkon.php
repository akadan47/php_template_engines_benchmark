<?php

//version 2.0
class Gekkon {

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
    }

    function register($name, $data)
    {
        $this->data[$name] = $data;
    }

    function display($tpl_name)
    {
        r_log('Display: '.$tpl_name, 'gekkon');
        $tpl_time = 0;
        if(is_file($tpl_file = $this->full_tpl_path($tpl_name)))
                $tpl_time = filemtime($tpl_file);

        $bin_time = 0;
        if(is_file($bin_file = $this->full_bin_path($tpl_name)))
                $bin_time = filemtime($bin_file);

        if($tpl_time == 0)
                return r_error('Template '.$tpl_name.' cannot be found at '.$tpl_file,
                'gekkon');

        //if($bin_time<$tpl_time)
        {
            if(!$this->compile($tpl_name))
                    return r_error('Cannot compile '.$tpl_name, 'gekkon');
        }
        $this->tpl_name = $tpl_name;
        include_once $bin_file;
        $t = $this->fn_name($tpl_name);
        $t($this);
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

    function cache_path($tpl_name)
    {
        return dirname($this->full_bin_path($tpl_name)).'/'.$this->fn_name($tpl_name).'_cache/';
    }

    function cache_file($stream_raw = 'none')
    {
        global $_reactor;
        $cid = MD5(serialize(array($stream_raw, $_reactor['language'])));
        return $cid[1].$cid[2].'/'.$cid;
    }

    function clear_cache($tpl_name, $stream_raw = '')
    {
        r_log('clear_cache '.$tpl_name.' - '.$stream_raw, 'gekkon');
        $cache_path = $this->cache_path($tpl_name);

        if($stream_raw != '')
        {
            $cache_file = $cache_path.$this->cache_file($stream_raw);
            r_log('cid '.$cache_file, 'gekkon');

            if(is_file($cache_file)) unlink($cache_file);
            return;
        }
        if(is_dir($cache_path)) $this->clear_dir($cache_path);
    }

    function clear_dir($path)
    {
        if($dh = opendir($path))
        {
            while(($file = readdir($dh)) !== false)
                if($file[0] != '.')
                {
                    if(is_dir($path.$file))
                    {
                        Gekkon::clear_dir($path.$file.'/');
                        rmdir($path.$file);
                    }
                    else unlink($path.$file);
                }
            closedir($dh);
        }
    }

    function compile($tpl_name)
    {
        if(!$this->compiler)
        {
            include_once $this->gekkon_path.'compiler.php';
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

        if($tpl_name[0] == '!')
                $bin_path = $this->bin_path.abs(crc32($tpl_name)).'/';
        else
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

}

//end of class -----------------------------------------------------------------

function r_log($msg)
{

}

function r_error($msg)
{
    echo $msg."<br>\n";
    return false;
}

