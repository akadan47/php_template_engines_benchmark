<?php
require('../../data.php');
require('../../common.php');

$method = $is_json ? "fetch" : "display";

$start = microtime(true);
$memory_start = memory_get_usage();
require('../../engines/smarty_2.6.28/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = './tpl';
$smarty->compile_dir = './tpl/cache';
if ($is_clear) $smarty->clear_cache("main.tpl");
$time_init = microtime(true)-$start;
$start_render = microtime(true);
$smarty->assign($_DATA);
$smarty->$method("main.tpl");
$memory = memory_get_usage() - $memory_start;
$time = microtime(true)-$start;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time, $time_init, $time_render, $memory);