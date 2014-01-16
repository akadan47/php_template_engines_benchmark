<?php
require('../data.php');

$is_json = isset($_GET['json']);
$is_include = isset($_GET['include']);
$is_clear = isset($_GET['clear']);

$tpl = $is_include ? "main_inc.tpl.twig" : "main.tpl.twig";
$method = $is_json ? "render" : "display";

$start_init = microtime(true);
require('../_lib/twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('tpl');
$twig = new Twig_Environment($loader, array('cache' => 'tpl/cache', 'autoescape' => false, 'auto_reload' => false));
$start_render = microtime(true);
$template = $twig->loadTemplate($tpl);
if ($is_clear) $twig->clearTemplateCache();
$template->$method($_DATA);
$time_init = microtime(true)-$start_init;
$time_render = microtime(true)-$start_render;

if ($is_json) {
    header('Content-type: application/json');
    echo json_encode(array("time_init"=>$time_init, "time_render"=>$time_render));
} else
    echo "<div id=\"time\"><b>Time</b>: ".$time_init." <b>Render</b>: ".$time_render."</div>";
