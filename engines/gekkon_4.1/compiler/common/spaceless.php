<?php

class gekkon_tag_spaceless extends gekkon_base_tag {

    function compile($compiler)
    {
        $var_cur = '$_gkn_spaceless'.$compiler->getUID();
        $rez = "ob_start();\n".
            $compiler->compile_str($this->content_raw, $this).
            "$var_cur = ob_get_contents();".
            "ob_end_clean();\n".
            "echo preg_replace('/>\s+</Uis', '><',preg_replace('/\s+/is', ' ', $var_cur));\n";
        return $rez;
    }

}

//end of class