<?php

function gekkon_tag_include_single($compiler, $_tag)
{
    $exp = $compiler->exp_compiler->compile_exp($_tag['raw_args']);
    if($exp === false)
            return r_error('gekkon: tag include: Cannot compile expression');
    return '$gekkon->display('.$exp.");\n";
}

