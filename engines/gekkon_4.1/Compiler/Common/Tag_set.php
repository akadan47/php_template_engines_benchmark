<?php

namespace Gekkon;

class Tag_set extends BaseTagSingle {

    function compile($compiler)
    {
        $_rez = '';
        $exp = $compiler->exp_compiler->compile_exp($this->args_raw);

        if($exp === false)
                return $compiler->error_in_tag('Cannot compile expression "'.$this->args_raw.'"',
                            $this);

        return $exp.";\n";
    }

}

