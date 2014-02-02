<?php

namespace Gekkon;

class BaseTag {

    var $parent;
    var $args_raw = '';
    var $open_raw = '';
    var $content_raw = '';
    var $name = '';
    var $system = '';
    var $line;
    var $start_token;
    var $end_token;
    var $open_start = 0;
    var $open_length = 0; //with tokens
    var $close_length = 0;

    function compile($compiler)
    {
        return '';
    }

    function custom_handler($compiler, $_str)
    {
        return true;
    }

    function get_closer()
    {
        return '/'.$this->name;
    }

    function total_lines()
    {
        return $this->open_lines() +
                substr_count($this->content_raw, "\n");
    }

    function open_lines()
    {
        return substr_count($this->open_raw, "\n");
    }

    function copy($_tag)
    {
        foreach($_tag as $k => $v)
        {
            if(is_object($_tag->$k)) $this->$k = &$_tag->$k;
            else $this->$k = $_tag->$k;
        }
    }

    function total_length()
    {
        return $this->open_length + mb_strlen($this->content_raw) + $this->close_length;
    }

}

//end of class