<?php

namespace Gekkon;

class Tag_if extends BaseTag {

    function compile($compiler)
    {
        $_rez = '';
        $exp = $compiler->exp_compiler->compile_exp($this->args_raw);

        if($exp === false)
                return $compiler->error_in_tag('Cannot compile expression "'.$this->args_raw.'"',
                            $this);

        $_rez = "if(".$exp."){\n";
        return $_rez.
                $compiler->compile_str($this->content_raw, $this).
                "}\n";
    }

}

//end of class