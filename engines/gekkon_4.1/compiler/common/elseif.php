<?php

class gekkon_tag_elseif extends gekkon_base_tag_single {

    function compile($compiler)
    {
        $allowed_context = array('if');
        if(!in_array($this->parent->name, $allowed_context))
        {
            $compiler->error_in_tag('Can be used only inside of following tags: ['.
                implode(', ', $allowed_context).']', $this);
            return false;
        }

        $exp = $compiler->exp_compiler->compile_exp($this->args_raw);

        if($exp === false)
                return $compiler->error_in_tag('Cannot compile expression "'.$this->args_raw.'"',
                    $this);

        return "}elseif(".$exp."){\n";
    }

}

//end of class