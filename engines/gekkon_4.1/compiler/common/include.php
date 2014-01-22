<?php

class gekkon_tag_include extends gekkon_base_tag_single {

    function compile($compiler)
    {
        $exp = $compiler->exp_compiler->compile_exp($this->args_raw);
        if($exp === false)
                return $compiler->error_in_tag('Cannot compile args "'.$this->args_raw.'"',
                    $this);

        return '$gekkon->display('.$exp.");\n";
    }

}

//end of class