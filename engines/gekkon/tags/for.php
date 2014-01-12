<?php

function gekkon_tag_for($compiler, $_tag)
{
    $exp_compiler = &$compiler->exp_compiler;
    //PHP for syntax
    $args_data = $exp_compiler->parse_expression($_tag['raw_args']);
    if($args_data === false)
            return $compiler->error_in_tag('Cannot parse args "'.$_tag['raw_args'].'"',
                $_tag);

    $args = $exp_compiler->parse_construction($args_data,
        array('<exp>', ';', '<exp>', ';', '<exp>'));

    if($args === false)
            return $compiler->error_in_tag('Cannot parse args "'.$_tag['raw_args'].'"',
                $_tag);
    else
    {
        $args = $exp_compiler->compile_construction_expressions($args);
        if($args === false)
                return $compiler->error_in_tag('Cannot compile args "'.$_tag['raw_args'].'"',
                    $_tag);
    }

    return "for(".$args[0].";".$args[2].";".$args[4]."){\n".
        $compiler->compile_str($_tag['content']).
        "}\n";
}

