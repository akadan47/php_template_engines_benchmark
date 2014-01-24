<?php

$is_json = isset($_GET['json']);
$is_clear = isset($_GET['clear']);

function print_time($is_json, $generation, $init, $render, $memory)
{
    if ($is_json) {
        header('Content-type: application/json');
        echo json_encode(array("generation"=>$generation, "init"=>$init, "render"=>$render, "memory"=>$memory));
    } else
        echo "<div id=\"time\"><b>Time</b>: ".$generation." <b>Init</b>: ".$init." <b>Render</b>: ".$render." <b>Memory</b>: ".$memory."</div>";
}
