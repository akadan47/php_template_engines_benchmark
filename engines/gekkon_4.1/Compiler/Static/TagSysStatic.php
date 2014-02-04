<?php

namespace Gekkon;

class TagSysStatic {

    var $compiler;

    function __construct($compiler)
    {
        $this->compiler = $compiler;
        $this->sysCommon = new TagSysCommon($compiler);
        $this->sysEcho = new TagSysEcho($compiler);
        $this->allowedTags = array('echo', 'if', 'for', 'foreach', 'include');
    }

    function try_parse($_tag, $_str)
    {
        $new_tag = $this->sysCommon->try_parse($_tag, $_str);
        if($new_tag->system === '')
                $new_tag = $this->sysEcho->try_parse($_tag, $_str);
        elseif(!in_array($new_tag->name, $this->allowedTags)) return $_tag;

        if($new_tag->system === '') return $new_tag;

        $_ready_tag = new StaticTagWrapper($new_tag);
        return $_ready_tag;
    }

}

//end of class