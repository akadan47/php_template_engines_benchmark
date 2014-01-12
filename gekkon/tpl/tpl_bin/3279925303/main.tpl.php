<?php

function gekkon__tpl_main_tpl(&$gekkon){
//Template /tpl/main.tpl;
echo '<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    ';
echo $gekkon->data['data'];
echo '
</body>
</html>';
}
