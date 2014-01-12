<?php
include '../data.inc';
require('../_lib/smarty/Smarty.class.php');

$smarty = new Smarty();
$smarty->template_dir = './tpl';
$smarty->compile_dir = './tpl/tpl_bin';
$start = microtime(true);
$smarty->assign($_DATA);
$smarty->fetch('main.tpl');
echo microtime(true)-$start;