<?php

class gekkon_tag_sys_common {

    var $compiler;

    function __construct(&$compiler)
    {
        $this->compiler = &$compiler;
    }

    function try_parse($_tag, &$_str)
    {
        if(!preg_match('/^\s*([a-zA-Z0-9_]+)(\s.+)?$/u', $_tag->open_raw,
                $preg_data)) return $_tag;

        $_tag_name = $preg_data[1];
        $_tag_args_raw = isset($preg_data[2]) ? $preg_data[2] : '';

        $handler = 'gekkon_tag_'.$_tag_name;
        if(!class_exists($handler)) return $_tag;

        $_new_tag = new $handler($this->compiler);
        $_new_tag->copy($_tag);
        $_new_tag->name = $_tag_name;
        $_new_tag->args_raw = $_tag_args_raw;
        $_new_tag = $this->parse_end_of_tag($_new_tag, $_str);

        if($_new_tag == false) return $_tag;
        $_new_tag->system = 'common';
        return $_new_tag;
    }

    function parse_end_of_tag($_tag, &$_str)
    {
        $closer = $_tag->get_closer();
        if($closer !== false)
        {
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
                '/Usu', $_str, $opens, PREG_OFFSET_CAPTURE);

            preg_match_all('/'.$open_token.
                '\s*'.$closer.'\s*'.
                $close_token.
                '/u', $_str, $closes, PREG_OFFSET_CAPTURE);

            foreach($opens[0] as $item)
            {
                if($item[1] > $now)
                {
                    $open_and_closes[$item[1]]['type'] = 1;
                    $open_and_closes[$item[1]]['len'] = mb_strlen($item[0]);
                }
            }

            foreach($closes[0] as $item)
            {
                if($item[1] > $now)
                {
                    $open_and_closes[$item[1]]['type'] = -1;
                    $open_and_closes[$item[1]]['len'] = mb_strlen($item[0]);
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
                    $end_len = $item['len'];
                    break;
                }
            }
            if($f == 0)
            {
                $_tag->content_raw = substr($_str, 0, $pos);
                $_tag->close_start = $pos;
                $_tag->close_length = $end_len;
            }
        }
        return $_tag;
    }

}

//end of class