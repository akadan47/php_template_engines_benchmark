<?php
require('../../data.php');
require('../../common.php');

$method = $is_json ? "get_display" : "display";

$start = microtime(true);
$memory_start = memory_get_usage();
require('../../engines/gekkon_4.1/gekkon.php');
$gekkon = new Gekkon(dirname(__file__), dirname(__file__).'/tpl/cache/', '/tpl/');
if ($is_clear) $gekkon->clear_cache("main.tpl");
$time_init = microtime(true)-$start;
$start_render = microtime(true);
$gekkon->register('data', $_DATA);
$gekkon->$method("main.tpl");
$memory = memory_get_usage() - $memory_start;
$time = microtime(true)-$start;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time, $time_init, $time_render, $memory);