<?php
include '../data.inc';
require('../_lib/gekkon/gekkon.php');

$gekkon = new Gekkon(dirname(__file__), dirname(__file__).'/tpl/tpl_bin/', '/tpl/');
$start = microtime(true);
$gekkon->register('data', $_DATA);
$gekkon->get_display('main.tpl');
echo microtime(true)-$start;