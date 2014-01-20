<?php

$is_json = isset($_GET['json']);
$is_include = isset($_GET['include']);
$is_clear = isset($_GET['clear']);

$tpl = $is_include ? "main_inc.tpl" : "main.tpl";

function print_time($is_json, $time_init, $time_render)
{
    if ($is_json) {
        header('Content-type: application/json');
        echo json_encode(array("time_init"=>$time_init, "time_render"=>$time_render));
    } else
        echo "<div id=\"time\"><b>Time</b>: ".$time_init." <b>Render</b>: ".$time_render."</div>";
}
