<?php

function gekkon_tag_if($compiler, $_tag)
{
    //print_r($_tag);die();
    $_rez = '';
    $exp = $compiler->exp_compiler->compile_exp($_tag['raw_args']);

    if($exp === false)
            return $compiler->error_in_tag('Cannot compile expression "'.$_tag['raw_args'].'"',
                $_tag);

    $_rez = "if(".$exp."){\n";
    return $_rez.
        $compiler->compile_str($_tag['content'], $_tag).
        "}\n";
}

