<?php
require('../data.php');
require('../_lib/gekkon/gekkon.php');

$is_json = isset($_GET['json']);
$is_include = isset($_GET['include']);

$tpl = $is_include ? "main_inc.tpl" : "main.tpl";
$method = $is_json ? "get_display" : "display";

$gekkon = new Gekkon(dirname(__file__), dirname(__file__).'/tpl/cache/', '/tpl/');

$start = microtime(true);
$gekkon->register('data', $_DATA);
$gekkon->$method($tpl);
$time = microtime(true)-$start;

if ($is_json) {
    header('Content-type: application/json');
    echo json_encode(array("time"=>$time));
} else
    echo "<div id=\"time\"><b>Time</b>: ".$time."</div>";