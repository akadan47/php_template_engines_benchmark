<?php

function gekkon_tag_ifchange($compiler, $_tag)
{
    //Parameters
    $exp = false;
    if(trim($_tag['raw_args']) !== '')
    {
        $exp = $compiler->exp_compiler->compile_exp($_tag['raw_args']);
        if($exp === false)
                return $compiler->error_in_tag('Cannot compile expression "'.$_tag['raw_args'].'"',
                    $_tag);
    }

    //handle else
    $content = $compiler->parse_str($_tag['content'], $_tag);
    if($content === false)
            return $compiler->error_in_tag('Cannot parse tag content', $_tag);

    $content = $compiler->split_parsed_str($content, 'else');
    $else = '';
    if(isset($content[1]))
    {
        $else = "else {\n".
            $compiler->compile_parsed_str($content[1]).
            "}\n";
    }
    $content = $content[0];


    //the tag logic; compare last and current
    $var_last = '$_gkn_ifchange_l'.$compiler->getUID();
    $var_cur = '$_gkn_ifchange_c'.$compiler->getUID();
    if($exp !== false)
    {
        $value = "$var_cur = $exp;\n";
        $show = $compiler->compile_parsed_str($content);
    }
    else
    {
        $value = "ob_start();\n".
            $compiler->compile_parsed_str($content).
            "$var_cur = ob_get_contents();".
            "ob_end_clean();\n";
        $show = "echo $var_cur;\n";
    }

    $condition = "if(!isset($var_last)||$var_last!==$var_cur){\n";


    return $value.
        $condition.
        $show.
        "}\n".
        $else.
        "$var_last=$var_cur;\n";
}

