<?php

class gekkon_tag_no_parse extends gekkon_base_tag {

    function compile($compiler)
    {
        if($this->content_raw == '') return '';
        return 'echo '.var_export($this->content_raw, true).";\n";
    }

}

//end of class
