<?php
include '../data.inc';
require('../_lib/smarty/Smarty.class.php');

$smarty = new Smarty();
$smarty->template_dir = './tpl';
$smarty->compile_dir = './tpl/tpl_bin';
$start = microtime(true);
$smarty->assign($_DATA);

if(isset($_GET['include'])){
    if(isset($_GET['time'])) {
        $smarty->fetch('main_inc.tpl');
    } else {
        $smarty->display('main_inc.tpl');
    }
} else {
    if(isset($_GET['time'])) {
        $smarty->fetch('main.tpl');
    } else {
        $smarty->display('main.tpl');
    }
}
if(isset($_GET['time'])) {
    header('Content-type: application/json');
    echo "{\"time\":".(microtime(true)-$start)."}";
} else {
    echo "<div id=\"time\"><b>Time</b>: ".(microtime(true)-$start)."</div>";
}