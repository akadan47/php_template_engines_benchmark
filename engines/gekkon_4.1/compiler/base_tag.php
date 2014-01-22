<?php

class gekkon_base_tag {

    var $parent;
    var $args_raw = '';
    var $open_raw = '';
    var $content_raw = '';
    var $name = '';
    var $system = '';
    var $line;
    var $start_token;
    var $end_token;
    var $open_start;
    var $open_length; //with tokens
    var $close_length;

    function compile($compiler)
    {
        return '';
    }

    function get_closer()
    {
        return '/'.$this->name;
    }

    function count_lines()
    {
        return $this->count_open_lines() +
            substr_count($this->content_raw, "\n");
    }

    function count_open_lines()
    {
        return
            substr_count($this->open_raw, "\n");
    }

    function close_start()
    {
        return mb_strlen($this->content_raw);
    }

    function copy($_tag)
    {
        foreach($_tag as $k => $v)
        {
            if(is_object($_tag->$k)) $this->$k = &$_tag->$k;
            else $this->$k = $_tag->$k;
        }
    }

}

//end of class