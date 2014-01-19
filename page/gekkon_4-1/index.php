<?php
require('../../data.php');
require('../../common.php');

$method = $is_json ? "get_display" : "display";

$start_init = microtime(true);
require('../../engines/gekkon_4.1/gekkon.php');
$gekkon = new Gekkon(dirname(__file__), dirname(__file__).'/tpl/cache/', '/tpl/');
if ($is_clear) $gekkon->clear_cache($tpl);
$start_render = microtime(true);
$gekkon->register('data', $_DATA);
$gekkon->$method($tpl);
$time_init = microtime(true)-$start_init;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time_init, $time_render);