<?php

namespace Gekkon;

class TagSysCommon {

    var $compiler;

    function __construct(&$compiler)
    {
        $this->compiler = &$compiler;
    }

    function try_parse($_tag, $_str)
    {
        if(!preg_match('/^\s*([a-zA-Z0-9_]+)(\s.+)?$/u', $_tag->open_raw,
                        $preg_data)) return $_tag;

        $_tag_name = $preg_data[1];
        $_tag_args_raw = isset($preg_data[2]) ? $preg_data[2] : '';

        $handler = __NAMESPACE__.'\Tag_'.$_tag_name;
        if(!class_exists($handler)) return $_tag;

        $_new_tag = new $handler($this->compiler);
        $_new_tag->copy($_tag);
        $_new_tag->name = $_tag_name;
        $_new_tag->system = 'common';
        $_new_tag->args_raw = $_tag_args_raw;
        $_ready_tag = $this->parse_end_of_tag($_new_tag, $_str);

        if($_ready_tag === false)
        {
            $this->compiler->error_in_tag('Cannot find closing tag '.$_new_tag->get_closer($_str),
                    $_new_tag);
            return $_tag;
        }

        return $_ready_tag;
    }

    function parse_end_of_tag($_tag, $_str)
    {
        $closer = $_tag->get_closer($_str);
        if($closer === false) return $_tag;

        $opens = array();
        $closes = array();
        $open_and_closes = array();
        $now = 0;
        $closer = preg_quote($closer, '/');
        $open_token = preg_quote($_tag->start_token, '/');
        $close_token = preg_quote($_tag->end_token, '/');
        preg_match_all('/'.$open_token.
                '\s*'.$_tag->name.'(\s.+)?'.
                $close_token.
                '/Usu', $_str, $opens, PREG_OFFSET_CAPTURE, $_tag->open_length);

        preg_match_all('/'.$open_token.
                '\s*'.$closer.'\s*'.
                $close_token.
                '/Uu', $_str, $closes, PREG_OFFSET_CAPTURE, $_tag->open_length);

        foreach($opens[0] as $item)
        {
            if($item[1] > $now)
            {
                $open_and_closes[$item[1]]['type'] = 1;
                $open_and_closes[$item[1]]['str'] = $item[0];
            }
        }

        foreach($closes[0] as $item)
        {
            if($item[1] > $now)
            {
                $open_and_closes[$item[1]]['type'] = -1;
                $open_and_closes[$item[1]]['str'] = $item[0];
            }
        }

        ksort($open_and_closes);
        $f = 1;
        foreach($open_and_closes as $pos => $item)
        {
            $f += $item['type'];
            if($f == 0)
            {
                $now = $pos;
                $end_len = mb_strlen($item['str']);
                break;
            }
        }
        if($f == 0)
        {
            $_tag->content_raw = substr($_str, $_tag->open_length,
                    $pos - $_tag->open_length);
            $_tag->close_start = $pos;
            $_tag->close_length = $end_len;
            return $_tag;
        }
        else return false;
    }

}

//end of class