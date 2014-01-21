<?php
require('../../data.php');
require('../../common.php');

$method = $is_json ? "get" : "output";

$start = microtime(true);
require ('../../engines/dwoo_1.1.0/dwooAutoload.php');
$dwoo = new Dwoo_Core('tpl/cache/');
if ($is_clear) $dwoo->clearCache();
$time_init = microtime(true)-$start;
$start_render = microtime(true);
$dwoo->$method("tpl/main.tpl", $_DATA);

$time = microtime(true)-$start;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time, $time_init, $time_render);