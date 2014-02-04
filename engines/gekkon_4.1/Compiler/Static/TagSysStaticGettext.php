<?php

namespace Gekkon;

class TagSysStaticGettext {

    var $compiler;

    function __construct($compiler)
    {
        $this->compiler = $compiler;
        $this->sysGettext = new TagSysGettext($compiler);
    }

    function try_parse($_tag, $_str)
    {
        $new_tag = $this->sysGettext->try_parse($_tag, $_str);
        if($new_tag->system === '') return $new_tag;

        $_ready_tag = new StaticTagWrapper($new_tag);
        return $_ready_tag;
    }

}

//end of class