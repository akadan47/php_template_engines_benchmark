<?php
require('../../data.php');
require('../../common.php');

$tpl = $is_include ? "main_inc.tpl.twig" : "main.tpl.twig";
$method = $is_json ? "render" : "display";

$start_init = microtime(true);
require('../../engines/twig_1.15.0/twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('tpl');
$twig = new Twig_Environment($loader, array('cache' => 'tpl/cache', 'autoescape' => false, 'auto_reload' => false));
$start_render = microtime(true);
if ($is_clear) $twig->clearTemplateCache();
$template = $twig->loadTemplate($tpl);
$template->$method($_DATA);
$time_init = microtime(true)-$start_init;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time_init, $time_render);