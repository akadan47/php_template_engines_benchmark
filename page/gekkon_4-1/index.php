<?php
require('../../data.php');
$is_json = isset($_GET['json']);
$is_include = isset($_GET['include']);
$is_clear = isset($_GET['clear']);

$tpl = $is_include ? "main_inc.tpl" : "main.tpl";
$method = $is_json ? "get_display" : "display";

$start_init = microtime(true);
require('../../engines/gekkon_4.1/gekkon.php');
$gekkon = new Gekkon(dirname(__file__), dirname(__file__).'/tpl/cache/', '/tpl/');
if ($is_clear) $gekkon->clear_cache($tpl);
$start_render = microtime(true);
$gekkon->register('data', $_DATA);
$gekkon->$method($tpl);
$time_init = microtime(true)-$start_init;
$time_render = microtime(true)-$start_render;

if ($is_json) {
    header('Content-type: application/json');
    echo json_encode(array("time_init"=>$time_init, "time_render"=>$time_render));
} else
    echo "<div id=\"time\"><b>Time</b>: ".$time_init." <b>Render</b>: ".$time_render."</div>";