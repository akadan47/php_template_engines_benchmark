<?php

namespace Gekkon;

class Tag_else extends BaseTagSingle {

    function compile($compiler)
    {
        $allowed_context = array('if');
        if(!in_array($this->parent->name, $allowed_context))
        {
            $compiler->error_in_tag('Can be used only inside of following tags: ['.
                    implode(', ', $allowed_context).']', $this);
            return false;
        }
        return "}else{\n";
    }

}

//end of class

