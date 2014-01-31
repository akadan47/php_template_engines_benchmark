<?php

namespace Gekkon;

class Tag_empty extends BaseTagSingle {

    function compile($compiler)
    {
        $allowed_context = array('foreach');
        if(!in_array($this->parent->name, $allowed_context))
        {
            $compiler->error_in_tag('Can be used only inside of following tags: ['.
                    implode(', ', $allowed_context).']', $this);
            return false;
        }
        return '';
    }

}

//end of class

