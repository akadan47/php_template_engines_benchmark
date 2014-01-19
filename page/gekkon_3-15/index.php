<?php
require('../../data.php');
require('../../common.php');
define("GEKKON_TRACE", 0);

$method = $is_json ? "display_into" : "display";

$start_init = microtime(true);
require('../../engines/gekkon_3.15/Gekkon.php');
$gekkon = new Gekkon(dirname(__file__).'/tpl/cache/', dirname(__file__).'/tpl/');
if ($is_clear) $gekkon->clear_cache($tpl);
$start_render = microtime(true);
$gekkon->register('data', $_DATA);
$gekkon->$method($tpl);
$time_init = microtime(true)-$start_init;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time_init, $time_render);