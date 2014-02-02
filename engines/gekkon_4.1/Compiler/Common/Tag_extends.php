<?php

namespace Gekkon;

class Tag_extends extends BaseTagSingle {

    function compile($compiler)
    {
        $exp = $compiler->exp_compiler->compile_exp($this->args_raw);

        if($exp === false)
                return $compiler->error_in_tag('Cannot compile expression "'.$this->args_raw.'"',
                            $this);

        return "\$_gkn_extends=\$gekkon->template($exp);\n".
                "\$template->extend(\$_gkn_extends)->display(\$gekkon,\$scope);\n".
                "return;\n";
    }

}

