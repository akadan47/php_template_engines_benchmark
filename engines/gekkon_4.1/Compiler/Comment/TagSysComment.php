<?php

namespace Gekkon;

//sys_gettext is a tag system and tag in the same time
class TagSysComment extends BaseTag {

    var $compiler;

    function __construct(&$compiler)
    {
        $this->compiler = &$compiler;
    }

    function try_parse($_tag, &$_str)
    {
        $this->copy($_tag);
        $this->system = 'comment';
        return $this;
    }

    function compile($compiler)
    {
        return '';
    }

}

//end of class