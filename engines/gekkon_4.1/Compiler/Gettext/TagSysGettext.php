<?php

namespace Gekkon;

//sys_gettext is a tag system and tag in the same time
class TagSysGettext extends BaseTagSingle {

    var $compiler;

    function __construct(&$compiler)
    {
        $this->compiler = &$compiler;
    }

    function try_parse($_tag, &$_str)
    {
        if($_tag->open_raw === '') return $_tag;
        $_new_tag = new TagSysGettext($this->compiler);
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

            return $compiler->compileOutput("gettext($exp)");
            $static = create_function('$gekkon,$_scope', "return gettext($exp);");

            return $compiler->compileOutput(var_export($static($compiler->gekkon,
                                            $compiler->gekkon->data), true));
        }
        $static = create_function('',
                "return ".$compiler->compileOutput(
                        var_export(gettext($this->args_raw), true), true).";");
        return $static();
    }

}

