<?php
require('../../data.php');
require('../../common.php');

$method = $is_json ? "render" : "display";

$start = microtime(true);
require('../../engines/twig_1.15.0/twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('tpl');
$twig = new Twig_Environment($loader, array('cache' => 'tpl/cache', 'autoescape' => false, 'auto_reload' => false));
$time_init = microtime(true)-$start;
$start_render = microtime(true);
if ($is_clear) $twig->clearTemplateCache();
$template = $twig->loadTemplate("main.tpl.twig");
$template->$method($_DATA);
$time = microtime(true)-$start;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time, $time_init, $time_render);