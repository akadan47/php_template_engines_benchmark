<?php

namespace Gekkon;

class Tag_block extends BaseTag {

    function compile($compiler)
    {
        $block_name = trim($this->args_raw);

        if($block_name === '')
                return $compiler->error_in_tag('Missing block name', $this);


        $compiler->binTplCode->blocks[$block_name] =
                $compiler->compile_str($this->content_raw, $this);

        return "\$template->display(\$gekkon,\$scope,'$block_name');\n";
    }

}

