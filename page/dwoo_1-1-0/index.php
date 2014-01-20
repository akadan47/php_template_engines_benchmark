<?php
require('../../data.php');
require('../../common.php');

$method = $is_json ? "get" : "output";
$tpl = $is_include ? "tpl/main_inc.tpl" : "tpl/main.tpl";

$start_init = microtime(true);
require ('../../engines/dwoo_1.1.0/dwooAutoload.php');
$dwoo = new Dwoo_Core('tpl/cache/');
if ($is_clear) $dwoo->clearCache();
$start_render = microtime(true);
$dwoo->$method($tpl, $_DATA);
$time_init = microtime(true)-$start_init;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time_init, $time_render);