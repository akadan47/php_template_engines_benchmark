<?php

function gekkon_tag_spaceless($compiler, $_tag)
{
    $var_cur = '$_gkn_spaceless'.$compiler->getUID();
    $rez = "ob_start();\n".
        $compiler->compile_str($_tag['content'], $_tag).
        "$var_cur = ob_get_contents();".
        "ob_end_clean();\n".
        "echo preg_replace('/>\s+</Uis', '><',preg_replace('/\s+/is', ' ', $var_cur));\n";
    return $rez;
}

