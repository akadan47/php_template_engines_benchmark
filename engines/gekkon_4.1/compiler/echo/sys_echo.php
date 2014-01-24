<?php

class gekkon_tag_sys_echo extends gekkon_base_tag_single {

    var $compiler;

    function __construct(&$compiler)
    {
        $this->compiler = &$compiler;
    }

    function try_parse($_tag, &$_str)
    {
        if(!preg_match('/^[\$\@\=].+$/u', $_tag->open_raw)) return $_tag;
        $new_tag = new gekkon_tag_echo();
        $new_tag->copy($_tag);
        $new_tag->args_raw = ltrim($new_tag->open_raw, '=');
        $new_tag->system = 'echo';
        return $new_tag;
    }

}

//end of class

