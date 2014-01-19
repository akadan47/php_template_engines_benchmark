<?php
$bin_open="<?php ob_start(); ?>";
$bin_close="<?php \$content = ob_get_contents();".
           "ob_end_clean();\n".
           "echo preg_replace('/>\s+</Uis', '><',preg_replace('/\s+/is', ' ', \$content));\n";
?>