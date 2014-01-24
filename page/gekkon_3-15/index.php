<?php
require('../../data.php');
require('../../common.php');
define("GEKKON_TRACE", 0);

$method = $is_json ? "display_into" : "display";

$start = microtime(true);
$memory_start = memory_get_usage();
require('../../engines/gekkon_3.15/Gekkon.php');
$gekkon = new Gekkon(dirname(__file__).'/tpl/cache/', dirname(__file__).'/tpl/');
if ($is_clear) $gekkon->clear_cache("main.tpl");
$time_init = microtime(true)-$start;
$start_render = microtime(true);
$gekkon->register('data', $_DATA);
$gekkon->$method("main.tpl");
$memory = memory_get_usage() - $memory_start;
$time = microtime(true)-$start;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time, $time_init, $time_render, $memory);