<?php
require('../../data.php');
require('../../common.php');

$method = $is_json ? "fetch" : "display";

$start_init = microtime(true);
require('../../engines/smarty_2.6.28/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = './tpl';
$smarty->compile_dir = './tpl/cache';
if ($is_clear) $smarty->clear_cache($tpl);
$start_render = microtime(true);
$smarty->assign($_DATA);
$smarty->$method($tpl);
$time_init = microtime(true)-$start_init;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time_init, $time_render);