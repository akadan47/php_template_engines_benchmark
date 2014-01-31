<?php

namespace Gekkon;

class Tag_no_parse extends BaseTag {

    function compile($compiler)
    {
        if($this->content_raw == '') return '';
        /* return "?>\n".$this->content_raw."<?php\n";/* */
        return 'echo '.var_export($this->content_raw, true).";\n";
    }

}

//end of class
