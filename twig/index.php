<?php
require('../data.php');
require('../_lib/twig/Autoloader.php');

$is_json = isset($_GET['json']);
$is_include = isset($_GET['include']);

$tpl = $is_include ? "main_inc.tpl.twig" : "main.tpl.twig";
$method = $is_json ? "render" : "display";

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('tpl');
$twig = new Twig_Environment($loader, array('cache' => 'tpl/cache', 'autoescape' => false, 'auto_reload' => false));

$start = microtime(true);
$template = $twig->loadTemplate($tpl);
$template->$method($_DATA);
$time = microtime(true)-$start;

if ($is_json) {
    header('Content-type: application/json');
    echo json_encode(array("time"=>$time));
} else
    echo "<div id=\"time\"><b>Time</b>: ".$time."</div>";
