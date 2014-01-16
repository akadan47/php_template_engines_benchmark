<?php
require('../data.php');
require('../_lib/smarty/Smarty.class.php');

$is_json = isset($_GET['json']);
$is_include = isset($_GET['include']);

$tpl = $is_include ? "main_inc.tpl" : "main.tpl";
$method = $is_json ? "fetch" : "display";

$smarty = new Smarty();
$smarty->template_dir = './tpl';
$smarty->compile_dir = './tpl/cache';

$start = microtime(true);
$smarty->assign($_DATA);
$smarty->$method($tpl);
$time = microtime(true)-$start;

if ($is_json) {
    header('Content-type: application/json');
    echo json_encode(array("time"=>$time));
} else
    echo "<div id=\"time\"><b>Time</b>: ".$time."</div>";