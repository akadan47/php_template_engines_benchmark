<?php

namespace Gekkon;

class Tag_ifchange extends BaseTag {

    function compile($compiler)
    {
        //Parameters
        $exp = false;
        if(trim($this->args_raw) !== '')
        {
            $exp = $compiler->exp_compiler->compile_exp($this->args_raw);
            if($exp === false)
                    return $compiler->error_in_tag('Cannot compile expression "'.$this->args_raw.'"',
                                $this);
        }

        //handle else
        $content = $compiler->parse_str($this->content_raw, $this);
        if($content === false)
                return $compiler->error_in_tag('Cannot parse tag content', $this);

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

}

//end of class
