<?php

class gekkon_tag_static extends gekkon_tag_no_parse {

    function __construct($content)
    {
        $this->content_raw = $content;
    }

}

//end of class

