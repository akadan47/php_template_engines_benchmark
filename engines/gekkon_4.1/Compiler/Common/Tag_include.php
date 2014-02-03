<?php

namespace Gekkon;

class Tag_include extends BaseTagSingle {

    function compile($compiler)
    {
        if(trim($this->args_raw) === '')
                return $compiler->error_in_tag('Missing args', $this);

        $additional_args = array('scope' => '$scope', 'block' => "'__main'");
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

        $additional_args['scope'] = $compiler->exp_compiler->join_scopes($additional_args['scope']);
        return '$gekkon->display('.$exp.', '.$additional_args['scope'].', '.$additional_args['block'].");\n";
    }

}

//end of class