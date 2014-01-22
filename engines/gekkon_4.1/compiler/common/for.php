<?php

class gekkon_tag_for extends gekkon_base_tag {

    function compile($compiler)
    {
        $args = false;
        $exp_compiler = &$compiler->exp_compiler;

        //HTML args syntax
        if($args === false)
        {
            $args_data = $exp_compiler->parse_args($this->args_raw);
            if(isset($args_data['from']) && isset($args_data['to']) && isset($args_data['key']))
            {
                $args_data = $exp_compiler->compile_construction_expressions($args_data);
                if(!isset($args_data['step'])) $args_data['step'] = 1;
                $args = array(
                    0 => $args_data['key'].'='.$args_data['from'],
                    2 => $args_data['key'].'<'.$args_data['to'],
                    4 => $args_data['key'].'+='.$args_data['step'],
                );
            }
        }

        //PHP for expression syntax
        if($args === false)
        {
            $args_data = $exp_compiler->parse_expression($this->args_raw);
            if($args_data === false)
                    return $compiler->error_in_tag('Cannot parse args "'.$this->args_raw.'"',
                        $this);

            $args = $exp_compiler->parse_construction($args_data,
                array('<exp>', ';', '<exp>', ';', '<exp>'));


            if($args !== false)
            {
                $args = $exp_compiler->compile_construction_expressions($args);
                if($args === false)
                        return $compiler->error_in_tag('Cannot compile args "'.$this->args_raw.'"',
                            $this);
            }
        }

        if($args === false)
                return $compiler->error_in_tag('Cannot parse args "'.$this->args_raw.'"',
                    $this);


        return "for(".$args[0].";".$args[2].";".$args[4]."){\n".
            $compiler->compile_str($this->content_raw, $this).
            "}\n";
    }

}

//end of class

