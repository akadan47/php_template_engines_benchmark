<?php
include '../data.inc';
require('../_lib/twig/Autoloader.php');

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('tpl');
$twig = new Twig_Environment($loader, array(
'cache' => 'tpl/tpl_bin',
'autoescape' => false,
'auto_reload' => false,
));
$start = microtime(true);

#$template->render($_DATA);


if(isset($_GET['include'])){
    if(isset($_GET['time'])) {
        $template = $twig->loadTemplate('main_inc.tpl');
        $template->render($_DATA);
    } else {
        $template = $twig->loadTemplate('main_inc.tpl');
        $template->display($_DATA);
    }
} else {
    if(isset($_GET['time'])) {
        $template = $twig->loadTemplate('main.tpl');
        $template->render($_DATA);
    } else {
        $template = $twig->loadTemplate('main.tpl');
        $template->display($_DATA);
    }
}
if(isset($_GET['time'])) {
    header('Content-type: application/json');
    echo "{\"time\":".(microtime(true)-$start)."}";
} else {
    echo "<div id=\"time\"><b>Time</b>: ".(microtime(true)-$start)."</div>";
}
