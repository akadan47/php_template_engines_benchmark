<?php

class gekkon_tag_sys_comment {

    var $compiler;

    function __construct(&$compiler)
    {
        $this->compiler = &$compiler;
    }

    function try_parse($_tag, &$_str)
    {
        $_new_tag = new gekkon_tag_comment($this->compiler);
        $_new_tag->copy($_tag);
        $_new_tag->system = 'comment';
        return $_new_tag;
    }

}

//end of class