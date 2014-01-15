<?php

function gekkon_tag_foreach($compiler, $_tag)
{
    $args = false;
    $exp_compiler = &$compiler->exp_compiler;
    //PHP foreach syntax
    if($args === false)
    {
        $args_data = $exp_compiler->parse_expression($_tag['raw_args']);
        if($args_data === false)
                return $compiler->error_in_tag('Cannot parse args "'.$_tag['raw_args'].'"',
                    $_tag);

        $args = $exp_compiler->parse_construction($args_data,
            array('<exp>', 'as', '<exp>', '=', '>', '<exp>', ';', '<exp>'),
            false);


        if($args === false)
                $args = $exp_compiler->parse_construction($args_data,
                array('<exp>', 'as', '<exp>', ';', '<exp>'), false);


        if($args !== false)
        {
            $compiler->errors = array();
            if(count($args) > 2)
            {
                $args = $exp_compiler->compile_construction_expressions($args);
                if($args === false)
                        return $compiler->error_in_tag('Cannot compile args "'.$_tag['raw_args'].'"',
                            $_tag);

                $x_args = array(
                    'from' => $args[0],
                    'item' => $args[2],
                );
                if(isset($args[5]))
                {
                    $x_args['key'] = $args[2];
                    $x_args['item'] = $args[5];
                }

                if(isset($args[4]) && $args[4] !== '>')
                {
                    $x_args['meta'] = $args[4];
                }
                if(isset($args[7])) $x_args['meta'] = $args[7];
                $args = $x_args;
            }
            else $args = false;
        }
    }

    //HTML args syntax
    if($args === false)
    {
        $args = $exp_compiler->parse_args($_tag['raw_args']);
        $args = $exp_compiler->compile_construction_expressions($args);
        if(!isset($args['from']))
                return $compiler->error_in_tag('Missing required argument "from"',
                    $_tag);

        if(!isset($args['item']))
                return $compiler->error_in_tag('Missing required argument "item"',
                    $_tag);

        if($args === false)
                return $compiler->error_in_tag('Cannot compile args "'.$_tag['raw_args'].'"',
                    $_tag);
    }

    //Check args parsing results
    if($args === false)
            return $compiler->error_in_tag('Cannot parse args "'.$_tag['raw_args'].'"',
                $_tag);

    $meta_init = '';
    $meta_body = '';
    if(isset($args['meta']))
    {
        $meta_name = $args['meta'];
        $meta_init = "\$_gkn_temp=count(".$args['from'].");
        ".$meta_name."=array(
        'first'=>1,
        'last'=>(\$_gkn_temp==1?1:0),
        'counter0'=>0,
        'counter'=>1,
        'revcounter0'=>\$_gkn_temp-1,
        'revcounter'=>\$_gkn_temp,
        'total'=>\$_gkn_temp,
        );\n";

        $meta_body = "
        ".$meta_name."['counter0']=".$meta_name."['counter']++;
        ".$meta_name."['revcounter']=".$meta_name."['revcounter0']--;
        ".$meta_name."['first']=0;
        ".$meta_name."['last']=(".$meta_name."['revcounter0']==0?1:0);
        ";
    }

    $loop_start = 'if(!empty('.$args['from'].")){\n";
    if(isset($args['key']))
            $loop_start .= 'foreach('.$args['from'].' as '.$args['key'].'=>'.$args['item']."){\n";
    else $loop_start .= 'foreach('.$args['from'].' as '.$args['item']."){\n";

    $content = $compiler->parse_str($_tag['content'], $_tag);
    if($content === false)
            return $compiler->error_in_tag('Cannot parse tag content', $_tag);

    $content = $compiler->split_parsed_str($content, 'empty');
    $empty = '';
    if(isset($content[1]))
    {
        $empty = 'else {'.
            $compiler->compile_parsed_str($content[1]).
            "}\n";
    }
    return $meta_init.
        $loop_start.
        $compiler->compile_parsed_str($content[0]).
        $meta_body.
        "}}\n".
        $empty;
}

