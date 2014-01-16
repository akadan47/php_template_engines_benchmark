<?php
require('../data.php');

$is_json = isset($_GET['json']);
$is_include = isset($_GET['include']);
$is_clear = isset($_GET['clear']);

$tpl = $is_include ? "main_inc.tpl" : "main.tpl";
$method = $is_json ? "fetch" : "display";

$start_init = microtime(true);
require('../_lib/smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = './tpl';
$smarty->compile_dir = './tpl/cache';
if ($is_clear) $smarty->clearCache($tpl);
$start_render = microtime(true);
$smarty->assign($_DATA);
$smarty->$method($tpl);
$time_init = microtime(true)-$start_init;
$time_render = microtime(true)-$start_render;


if ($is_json) {
    header('Content-type: application/json');
    echo json_encode(array("time_init"=>$time_init, "time_render"=>$time_render));
} else
    echo "<div id=\"time\"><b>Time</b>: ".$time_init." <b>Render</b>: ".$time_render."</div>";