<?php

class gekkon_tag_echo extends gekkon_base_tag_single {

    function compile($compiler)
    {
        $_rez = '';
        $exp = $compiler->exp_compiler->compile_exp($this->args_raw);

        if($exp === false)
                return $compiler->error_in_tag('Cannot compile args "'.$this->args_raw.'"',
                    $this);

        return 'echo '.$exp.";\n";
    }

}

//end of class