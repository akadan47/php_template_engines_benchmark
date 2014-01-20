<?php
require('../../data.php');
require('../../common.php');

function __autoload($className){
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    require '../../engines/fenom_1.4.8/'.$fileName;
}

$method = $is_json ? "fetch" : "display";

$start_init = microtime(true);
$fenom = Fenom::factory('./tpl', './tpl/cache');
$fenom->setOptions(array(
    "auto_trim" => true,
    "auto_reload" => true,
));
if ($is_clear) $fenom->clearAllCompiles();
$start_render = microtime(true);
$fenom->$method($tpl, $_DATA);
$time_init = microtime(true)-$start_init;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time_init, $time_render);
