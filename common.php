<?php

$is_json = isset($_GET['json']);
$is_clear = isset($_GET['clear']);

function print_time($is_json, $time, $time_init, $time_render)
{
    if ($is_json) {
        header('Content-type: application/json');
        echo json_encode(array("time"=>$time, "time_init"=>$time_init, "time_render"=>$time_render));
    } else
        echo "<div id=\"time\"><b>Time</b>: ".$time." <b>Init</b>: ".$time_init." <b>Render</b>: ".$time_render."</div>";
}
