<?php

function gekkon_tag_cache($compiler, $_tag)
{
    $exp_compiler = &$compiler->exp_compiler;
    $args = array();
    if(trim($_tag['raw_args']) != '')
    {
        $args = $exp_compiler->parse_args($_tag['raw_args']);
        $args = $exp_compiler->compile_construction_expressions($args);
    }

    if(!isset($args['timeout'])) $args['timeout'] = 0; //save it forever!
    if(!isset($args['id'])) $args['id'] = "''"; //save it forever!
    $salt = '_gkn_cache'.$compiler->getUID().$compiler->tpl_name;
    $id = $args['id'];
    $timeout = $args['timeout'];

    $rez = "\$_gkn_cache_file=".
        var_export($compiler->gekkon->cache_dir($compiler->tpl_name), true).
        ".\$gekkon->cache_file(".var_export($compiler->tpl_name, true).",$id);\n".
        "if(is_file(\$_gkn_cache_file))".
        "\$_gkn_cache_time=filemtime(\$_gkn_cache_file);\n".
        "else \$_gkn_cache_time=false;".
        "if(\$_gkn_cache_time===false || (time()-\$_gkn_cache_time>$timeout && $timeout!==0)){\n".
        "ob_start();\n".
        $compiler->compile_str($_tag['content'], $_tag).
        "\$gekkon->create_dir(dirname(\$_gkn_cache_file));\n".
        "file_put_contents(\$_gkn_cache_file,\$_gkn_cache_show=ob_get_contents());\n".
        "ob_end_clean();\n".
        "echo \$_gkn_cache_show;\n".
        "}else{\n".
        "readfile(\$_gkn_cache_file);\n".
        "}\n";

    return $rez;
}

