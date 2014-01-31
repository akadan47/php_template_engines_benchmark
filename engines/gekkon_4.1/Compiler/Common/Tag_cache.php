<?php

namespace Gekkon;

class Tag_cache extends BaseTag {

    function compile($compiler)
    {
        $exp_compiler = &$compiler->exp_compiler;
        $args = array();
        if(trim($this->args_raw) != '')
        {
            $args = $exp_compiler->parse_args($this->args_raw);
            $args = $exp_compiler->compile_construction_expressions($args);
        }

        if(!isset($args['timeout'])) $args['timeout'] = 0; //save it forever!
        if(!isset($args['id'])) $args['id'] = "''"; //save it forever!
        $id = $args['id'];
        $timeout = $args['timeout'];

        return "\$_gkn_cache=\$gekkon->cacheProvider->load(\$template,$id);\n".
                "if(\$_gkn_cache===false || (time()-\$_gkn_cache['created']>$timeout && $timeout!==0)){\n".
                "ob_start();\n".
                $compiler->compile_str($this->content_raw, $this).
                "\$gekkon->cacheProvider->save(\$template,\$_gkn_cache_show=ob_get_clean(),$id);\n".
                "echo \$_gkn_cache_show;\n".
                "}else{\n".
                "echo \$_gkn_cache['content'];\n".
                "}\n";
    }

}

//end of class