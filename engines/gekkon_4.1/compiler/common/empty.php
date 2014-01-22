<?php

class gekkon_tag_empty extends gekkon_base_tag_single {

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

