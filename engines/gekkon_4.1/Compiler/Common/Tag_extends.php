<?php

namespace Gekkon;

class Tag_extends extends BaseTagSingle {

    function compile($compiler)
    {
        $exp = $compiler->exp_compiler->compile_exp($this->args_raw);

        if($exp === false)
                return $compiler->error_in_tag('Cannot compile expression "'.$this->args_raw.'"',
                            $this);

        $compiler->binTplCode->blocks['__constructor'].=
                "\$_gkn_extends=\$gekkon->template($exp);\n".
                "\$template['blocks']+=\$_gkn_extends['blocks'];\n".
                "\$template['blocks']['__main']=\$_gkn_extends['blocks']['__main'];\n";

        $compiler->compile_str($this->content_raw, $this);
        return '';
    }

    function custom_handler($compiler, $_str)
    {
        $open_end = $this->open_length + $this->open_start;
        $this->content_raw = mb_substr($_str, $open_end); //to the end
        $this->close_length = 0;
        return true;
    }

}

