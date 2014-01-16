<?php
require('../data.php');
require('../_lib/smarty/Smarty.class.php');

$is_json = isset($_GET['json']);
$is_include = isset($_GET['include']);
$is_clear = isset($_GET['clear']);

$tpl = $is_include ? "main_inc.tpl" : "main.tpl";
$method = $is_json ? "fetch" : "display";

$smarty = new Smarty();
$smarty->template_dir = './tpl';
$smarty->compile_dir = './tpl/cache';
if ($is_clear) $smarty->clearCache($tpl);
$start = microtime(true);
$smarty->assign($_DATA);
$smarty->$method($tpl);
$time = microtime(true)-$start;

if ($is_json) {
    header('Content-type: application/json');
    echo json_encode(array("time"=>$time));
} else
    echo "<div id=\"time\"><b>Time</b>: ".$time."</div>";