<?php

class gekkon_tag_include extends gekkon_base_tag_single {

    function compile($compiler)
    {
        if(trim($this->args_raw) === '')
                return $compiler->error_in_tag('Missing args', $this);

        $additional_args = array('scope' => '$scope');
        if(preg_match('/\w+\s*=/u', $this->args_raw, $preg_data,
                        PREG_OFFSET_CAPTURE))
        {
            $exp = substr($this->args_raw, 0, $preg_data[0][1]);
            $args = substr($this->args_raw, $preg_data[0][1]);
            $args = $compiler->exp_compiler->parse_args($args);
            $args = $compiler->exp_compiler->compile_construction_expressions($args);
            $additional_args = $args + $additional_args;
        }
        else
        {
            $exp = $compiler->exp_compiler->compile_exp($this->args_raw);
        }

        if($exp === false)
                return $compiler->error_in_tag('Cannot compile args "'.$this->args_raw.'"',
                            $this);

        return '$gekkon->display('.$exp.', '.$additional_args['scope'].");\n";
    }

}

//end of class