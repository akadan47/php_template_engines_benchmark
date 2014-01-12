<?php

function gekkon_tag_elseif_single($compiler, $_tag)
{
    $allowed_context = array('if');
    if(!in_array($_tag['parent_name'], $allowed_context))
    {
        $compiler->error_in_tag('Can be used only inside of following tags: ['.
            implode(', ', $allowed_context).']', $_tag);
        return false;
    }

    $exp = $compiler->exp_compiler->compile_exp($_tag['raw_args']);

    if($exp === false)
            return $compiler->error_in_tag('Cannot compile expression "'.$_tag['raw_args'].'"',
                $_tag);

    return "}elseif(".$exp."){\n";
}
