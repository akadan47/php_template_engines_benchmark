<?php

//sys_gettext is a tag system and tag in the same time
class gekkon_tag_sys_gettext extends gekkon_base_tag_single {

    var $compiler;

    function __construct(&$compiler)
    {
        $this->compiler = &$compiler;
    }

    function try_parse($_tag, &$_str)
    {
        if($_tag->open_raw === '') return $_tag;
        $_new_tag = new gekkon_tag_sys_gettext($this->compiler);
        $_new_tag->copy($_tag);
        $_new_tag->args_raw = $_new_tag->open_raw;
        $_new_tag->system = 'gettext';
        return $_new_tag;
    }

    function compile($compiler)
    {
        if(preg_match('/\$\w/u', $this->args_raw))
        {
            $exp = "'".preg_replace('/([\$@][^\s]+)/u', "' . \\1 . '",
                            $this->args_raw)."'";
            $exp = $compiler->exp_compiler->compile_exp($exp);

            if($exp === false)
                    return $compiler->error_in_tag('Cannot compile args "'.$this->args_raw.'"',
                                $this);


            return "echo gettext($exp);\n";
            $static = create_function('$gekkon,$_scope', "return gettext($exp);");
            return "echo ".var_export($static($compiler->gekkon,
                                    $compiler->gekkon->data), true).";\n";
        }
        return "echo ".var_export(gettext($this->args_raw), true).";\n";
    }

}

