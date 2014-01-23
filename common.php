<?php

$is_json = isset($_GET['json']);
$is_clear = isset($_GET['clear']);

function print_time($is_json, $generation, $init, $render)
{
    if ($is_json) {
        header('Content-type: application/json');
        echo json_encode(array("generation"=>$generation, "init"=>$init, "render"=>$render));
    } else
        echo "<div id=\"time\"><b>Time</b>: ".$generation." <b>Init</b>: ".$init." <b>Render</b>: ".$render."</div>";
}
