<?php

class gekkon_tag_sys_echo {

    var $compiler;

    function __construct(&$compiler)
    {
        $this->compiler = &$compiler;
    }

    function try_parse($_tag, &$_str)
    {
        if(!preg_match('/^[\$\@\=].+$/u', $_tag->open_raw)) return $_tag;
        $_new_tag = new gekkon_tag_echo($this->compiler);
        $_new_tag->copy($_tag);
        $_new_tag->args_raw = ltrim($_new_tag->open_raw, '=');
        $_new_tag->system = 'echo';
        return $_new_tag;
    }

    function compile($_tag)
    {
        return gekkon_tag_echo_single($this->compiler, $_tag);
    }

}

//end of class

