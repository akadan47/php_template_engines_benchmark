<?php
include '../data.inc';
require('../_lib/gekkon/gekkon.php');
#error_reporting(E_ALL ^ E_NOTICE);

$gekkon = new Gekkon(dirname(__file__), dirname(__file__).'/tpl/tpl_bin/', '/tpl/');
$start = microtime(true);
$gekkon->register('data', $_DATA);

if(isset($_GET['include'])){
    if(isset($_GET['time'])) {
        $gekkon->get_display('main_inc.tpl');
    } else {
        $gekkon->display('main_inc.tpl');
    }
} else {
    if(isset($_GET['time'])) {
        $gekkon->get_display('main.tpl');
    } else {
        $gekkon->display('main.tpl');
    }
}
if(isset($_GET['time'])) {
    header('Content-type: application/json');
    echo "{\"time\":".(microtime(true)-$start)."}";
} else {
    echo "<div id=\"time\"><b>Time</b>: ".(microtime(true)-$start)."</div>";
}
