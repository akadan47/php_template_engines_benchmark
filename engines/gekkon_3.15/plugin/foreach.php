<?php
$bin_open='<?php foreach('.$tag['arg']['from'].' as ';
if(isset($tag['arg']['key']))
$bin_open.=$tag['arg']['key'].' => ';

$bin_open.=$tag['arg']['item'].'){ ?>';
$bin_close='<?php } ?>';
?>