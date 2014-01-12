<?php
include '../data.inc';
require('../engines/twig/Autoloader.php');

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('tpl');
$twig = new Twig_Environment($loader, array(
'cache' => 'tpl/tpl_bin',
'autoescape' => false,
'auto_reload' => false,
));
$start = microtime(true);
$template = $twig->loadTemplate('main.tpl');
$template->render($_DATA);
echo microtime(true)-$start;