<?php
require('../../data.php');
require('../../common.php');
define("GEKKON_TRACE", 0);

$file = $is_include ? "main_inc.php" : "main.php";

$start_init = microtime(true);
$code = file_get_contents("tpl/".$file);
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
$time_init = microtime(true)-$start_init;
$time_render = microtime(true)-$start_render;

print_time($is_json, $time_init, $time_render);