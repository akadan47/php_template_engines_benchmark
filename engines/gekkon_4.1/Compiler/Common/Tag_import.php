<?php

namespace Gekkon;

class Tag_import extends BaseTagSingle {

    function compile($compiler)
    {
        $exp = $compiler->exp_compiler->compile_exp($this->args_raw);

        if($exp === false)
                return $compiler->error_in_tag('Cannot compile expression "'.$this->args_raw.'"',
                            $this);

        $compiler->binTplCode->blocks['__constructor'].=
                "\$_gkn_import=\$gekkon->template($exp);\n".
                "\$template['blocks']+=\$_gkn_import['blocks'];\n";
        return '';
    }

}

