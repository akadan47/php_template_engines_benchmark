<?php

function gekkon_tag_else_single($compiler, $_tag)
{
    $allowed_context = array('if');
    if(!in_array($_tag['parent_name'], $allowed_context))
    {
        $compiler->error_in_tag('Can be used only inside of following tags: ['.
            implode(', ', $allowed_context).']', $_tag);
        return false;
    }
    return "}else{\n";
}

