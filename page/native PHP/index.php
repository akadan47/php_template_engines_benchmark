<?php
require('../../data.php');
require('../../common.php');


$start = microtime(true);
$memory_start = memory_get_usage();
$code = file_get_contents("tpl/main.php");
$time_init = microtime(true)-$start;
$start_render = microtime(true);
$data = $_DATA;
if ($is_json) {
    ob_start();
    eval(' ?>'.$code.'<?php ');
    $out = ob_get_contents();
    ob_end_clean();
} else {
    eval(' ?>'.$code.'<?php ');
}
$memory = memory_get_usage() - $memory_start;
$time = microtime(true)-$start;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time, $time_init, $time_render, $memory);