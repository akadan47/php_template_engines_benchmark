<?php

namespace Gekkon;

class StaticTagWrapper extends BaseTag {

    var $tag;

    function __construct($tag)
    {
        $this->copy($tag);
        $this->tag = $tag;
    }

    function compile($compiler)
    {
        $code = $this->tag->compile($compiler);

        if($code === false) return false;
        $gekkon = $compiler->gekkon;
        $scope = $compiler->gekkon->get_scope();
        ob_start();
        eval($code);
        return $compiler->compileOutput(var_export(ob_get_clean(), true));
    }

}

