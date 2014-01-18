<?php
$tag['inner']=preg_replace('/[\s ]+/Us',' ',$tag['inner']);
$tag['inner']=preg_replace('/>[\s ]+</Us','><',$tag['inner']);
?>