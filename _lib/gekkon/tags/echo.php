<?php

function gekkon_tag_echo_single($compiler, $_tag)
{
    $_rez = '';
    $exp = $compiler->exp_compiler->compile_exp($_tag['raw_args']);

    if($exp === false)
            return $compiler->error_in_tag('gekkon: tag echo: Cannot compile args',
                $_tag);

    return 'echo '.$exp.";\n";
}

