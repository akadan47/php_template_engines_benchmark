<?php

$tag['inner']=$this->compile_r($tag['inner']);
ob_start();
ob_clean();


eval('?>'.$tag['inner'].'<?');
$tag['inner']=ob_get_contents();

ob_end_clean();

?>