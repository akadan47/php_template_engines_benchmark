<?php

function gekkon_tag_no_parse($compiler, $_tag)
{
    return $compiler->compile_static($_tag['content']);
}

