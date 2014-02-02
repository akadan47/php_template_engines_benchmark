<?php

//version 4.2
class Gekkon {

    var $version = 4.3;
    var $gekkon_path;
    var $compiler;
    var $display_errors;
    var $settings;
    var $loaded;
    var $data;
    var $tplProvider;
    var $binTplProvider;
    var $cacheProvider;

    function __construct($tpl_path, $bin_path)
    {
        $this->gekkon_path = dirname(__file__).'/';
        $this->compiler = false;
        $this->display_errors = ini_get('display_errors') == 'on';
        $this->settings = array('force_compile' => false);
        $this->loaded = array();
        $this->data = new ArrayObject();
        $this->data['global'] = $this->data;
        $this->tplProvider = new TemplateProviderFS($tpl_path);
        $this->binTplProvider = new BinTplProviderFS($bin_path);
        $this->cacheProvider = new CacheProviderFS($bin_path);
    }

    function assign($name, $data)
    {
        $this->data[$name] = $data;
    }

    function register($name, $data)
    {
        $this->data[$name] = $data;
    }

    function display($tpl_name, $scope_data = false)
    {
        if(($binTemplate = $this->template($tpl_name)) !== false)
                $binTemplate->display($this, $this->get_scope($scope_data));
    }

    function get_display($tpl_name, $scope_data = false)
    {
        ob_start();
        $this->display($tpl_name, $scope_data);
        return ob_get_clean();
    }

    function template($tpl_name)//refactor
    {
        $tpl_full_name = $this->tplProvider->get_full_name($tpl_name);
        if(isset($this->loaded[$tpl_full_name]))
                return $this->loaded[$tpl_full_name];

        if(($template = $this->tplProvider->load($tpl_name)) === false)
                return $this->error('Template '.$tpl_name.' cannot be found at '.$tpl_full_name,
                            'gekkon');

        if($this->settings['force_compile']) $binTpl = false;
        else $binTpl = $this->binTplProvider->load($template);

        if($binTpl === false || !$template->check_bin($binTpl))
        {
            if(($binTpl = $this->compile($template)) === false)
                    return $this->error('Cannot compile '.$tpl_name, 'gekkon');
            $this->cacheProvider->clear_cache($binTpl);
        }

        return $this->loaded[$tpl_full_name] = $binTpl;
    }

    function clear_cache($tpl_name, $id = '')
    {
        if(($template = $this->tplProvider->load($tpl_name)) === false)
                return $this->error('Template '.$tpl_name.' cannot be found at '.$tpl_file,
                            'gekkon');
        if(($binTpl = $this->binTplProvider->load($template)) !== false)
                $this->cacheProvider->clear_cache($binTpl, $id);

        $this->binTplProvider->clear_cache($template);
    }

    function get_scope($data = false)
    {
        if($data !== false && $data !== $this->data)
        {
            $scope = new ArrayObject($data);
            $scope['global'] = $this->data;
            return $scope;
        }
        return $this->data;
    }

    function compile($template)
    {
        if(!$this->compiler)
        {
            include $this->gekkon_path.'settings.php';
            $this->settings += $settings;
            Gekkon::include_dir($this->gekkon_path.'Compiler');
            $this->compiler = new Gekkon\Compiler($this);
        }
        $this->binTplProvider->save($template,
                $this->compiler->compile($template));
        return $this->binTplProvider->load($template);
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
        if(is_dir($path))
        {
            $dirs = array();
            foreach(scandir($path) as $file)
            {
                if($file[0] != '.')
                {
                    $to_include = $path.'/'.$file;
                    if(is_dir($to_include)) $dirs[] = $to_include;
                    elseif(strtolower(strrchr($to_include, '.')) === '.php')
                    {
                        include_once $to_include;
                    }
                }
            }
            foreach($dirs as $dir) Gekkon::include_dir($dir);
        }
    }

    function clear_dir($path)
    {
        $path = rtrim($path, '/').'/';
        if(is_dir($path))
        {
            foreach(scandir($path) as $file)
            {
                if($file[0] != '.')
                {
                    if(is_dir($path.$file)) Gekkon::clear_dir($path.$file.'/');
                    else unlink($path.$file);
                }
            }
        }
    }

    function create_dir($path)
    {
        $path = rtrim($path, '/');
        if(!is_dir($path))
        {
            Gekkon::create_dir(dirname($path));
            mkdir($path);
        }
    }

}

//end of class -----------------------------------------------------------------

class TemplateProviderFS {

    private $base_dir;

    function __construct($base_dir)
    {
        $this->base_dir = $base_dir;
    }

    function load($short_name)
    {
        $file = $this->get_full_name($short_name);
        if(is_file($file))
                return new TemplateFS($file, $this->get_association_name($file));
        return false;
    }

    function get_full_name($name)
    {
        return $this->base_dir.$name;
    }

    private function get_association_name($name)
    {
        $name = basename($name);
        if(($t = strrpos($name, '_')) !== false) return substr($name, 0, $t);
        return $name;
    }

    function get_associated($template)
    {
        $rez = array();
        $dir = dirname($template->name).'/';
        foreach(scandir($dir) as $file)
        {
            if($file[0] != '.')
            {
                if(strrchr($file, '.') === '.tpl' && $template->association === $this->get_association_name($dir.$file))
                        $rez[] = new TemplateFS($dir.$file,
                            $this->get_association_name($dir.$file));
            }
        }
        return $rez;
    }

}

//end of class -----------------------------------------------------------------

class TemplateFS {

    var $name;
    var $association;

    function __construct($name, $association)
    {
        $this->name = $name;
        $this->association = $association;
    }

    function check_bin($binTemplate)
    {
        return filemtime($this->name) < $binTemplate->info['created'];
    }

    function source()
    {
        return file_get_contents($this->name);
    }

}

//end of class -----------------------------------------------------------------

class CacheProviderFS {

    private $baseDir;

    function __construct($baseDir)
    {

        $this->baseDir = $baseDir;
    }

    private function cache_dir($binTemplate)
    {
        return $this->baseDir.abs(crc32($binTemplate->info['association'])).'/cache/';
    }

    private function cache_file($tpl_name, $id = '')
    {
        $name = md5($id.$tpl_name);
        return $name[0].$name[1].'/'.$name;
    }

    function clear_cache($binTemplate, $id = '')
    {
        if($id !== '')
        {
            $cache_file = $this->cache_dir($binTemplate).
                    $this->cache_file($id);
            if(is_file($cache_file)) unlink($cache_file);
        }
        else Gekkon::clear_dir($this->cache_dir($binTemplate));
    }

    function save($binTemplate, $content, $id)
    {
        Gekkon::create_dir(dirname($cache_file = $this->cache_dir($binTemplate).
                        $this->cache_file($id)));
        file_put_contents($cache_file, $content);
    }

    function load($binTemplate, $id)
    {
        $cache_file = $this->cache_dir($binTemplate).
                $this->cache_file($binTemplate->info['name'], $id);
        if(is_file($cache_file))
                return array(
                'created' => filemtime($cache_file),
                'content' => file_get_contents($cache_file)
            );
        return false;
    }

}

//end of class -----------------------------------------------------------------

class BinTplProviderFS {

    private $base_dir;
    private $loaded = array();

    function __construct($base)
    {
        $this->base_dir = $base;
    }

    private function full_path($association)
    {
        $bin_name = basename($association);
        $bin_path = $this->base_dir.abs(crc32($association)).'/';
        return $bin_path.$bin_name.'.php';
    }

    function load($template)
    {
        if(isset($this->loaded[$template->name]))
                return $this->loaded[$template->name];

        $file = $this->full_path($template->association);
        if(is_file($file))
        {
            $bins = include($file);
            foreach($bins as $name => $blocks)
            {
                $this->loaded[$name] = new binTemplate($blocks);
            }
            return $this->loaded[$template->name];
        }
        return false;
    }

    function save($template, $binTplCodeSet)
    {
        Gekkon::create_dir(dirname($file = $this->full_path($template->association)));
        file_put_contents($file, '<?php return '.$binTplCodeSet->code());
    }

    function clear_cache($template)
    {
        if(is_file($file = $this->full_path($template->association)) !== false)
                unlink($file);
    }

}

//end of class -----------------------------------------------------------------

class binTemplate {

    var $blocks = array();
    var $info = array();
    var $parent = false;

    function __construct($blocks)
    {
        $this->blocks = $blocks['blocks'];
        $this->info = $blocks['info'];
    }

    function display($gekkon, $scope = false, $block = 'main')
    {
        if(isset($this->blocks[$block]))
                $this->blocks[$block]($this, $gekkon, $scope);
        elseif($this->parent !== false)
                $this->parent->display($gekkon, $scope, $block);
    }

    function extend($template)
    {
        $new_tpl = new binTemplate(array('blocks' => $this->blocks, 'info' => $this->info));
        $new_tpl->parent = $template;
        $new_tpl->blocks['main'] = $template->blocks['main'];
        return $new_tpl;
    }

}

