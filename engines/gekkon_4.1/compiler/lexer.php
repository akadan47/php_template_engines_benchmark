<?php

class GekkonLexer {

    var $str;
    var $length;
    var $rez;
    var $current;
    var $error;
    var $step;

    function parse_expression($str)
    {
        $this->init($str);
        $lexems = ' .:,;?![]{}<>-+/*=&^#%~';
        $before = $current = '';
        while($this->step < $this->length)
        {
            $before = $current;
            $current = $this->str[$this->step];
            if(strpos($lexems, $current) !== false)
            {
                if($current != ' ') $this->save($current, 'l');
            }
            else
            {
                $i = $this->find_variable_end($this->step);
                if($i === false)
                {
                    return false;
                }
                $this->save(substr($this->str, $this->step, $i - $this->step + 1),
                    'v');
                $this->step = $i;
            }
            $this->step++;
        }
        return $this->rez;
    }

    function init($str)
    {
        $this->str = $str;
        $this->step = 0;
        $this->error = '';
        $this->rez = array();
        $this->length = mb_strlen($this->str);
        $this->reccursive_cnt = 0;
    }

    function find_variable_end($start)
    {
        $before = $current = '';
        $stop_lexems = ' ,;?![]{}<>-+/*=&^#%~';
        $step = $start;
        while($step < $this->length)
        {
            $before = $current;
            $current = $this->str[$step];
            if($current == '(')
            {
                $step = $this->find_close($step, '(', ')');
                if($step === false)
                {
                    $this->error.= "Cannot find the end of the string, ) - expected\n";
                    return false;
                }
            }
            else if($current == '"' || $current == '\'')
            {
                $step = $this->find_close($step, $current, $current);
                if($step === false)
                {
                    $this->error.= 'Cannot find the end of the string, '.$current." - expected\n";
                    return false;
                }
            }
            else if($current == '-')
            {
                if($step + 1 < $this->length && $this->str[$step + 1] == '>')
                {
                    $step++;
                }
                else
                {
                    return $step - 1;
                }
            }
            else if(strpos($stop_lexems, $current) !== false)
            {
                return $step - 1;
            }
            $step++;
        }
        return $step - 1;
    }

    function save($buffer, $type)
    {
        if($buffer != '') $this->rez[] = array('t' => $type, 'v' => $buffer);
    }

    function find_close($start, $opener, $closer, $alt = '')
    {
        $this->reccursive_cnt++;
        if($this->reccursive_cnt > 500) die('not ok');
        $nested = 1;
        $before = $current = '';
        for($i = $start + 1; $i < $this->length; $i++)
        {
            $before = $current;
            $current = $this->str[$i];
            if($before != '\\')
            {
                if($opener != '"' && $opener != '\'')
                {
                    if($current == '"' || $current == '\'')
                    {
                        $i = $this->find_close($i, $current, $current);
                        if($i === false)
                        {
                            $this->error .= 'Cannot find the end of the string, '.$current." - expected\n";
                            return false;
                        }
                        continue;
                    }
                }

                if($current == $opener && $opener != $closer) $nested++;
                else if($current == $closer) $nested--;
                else if($nested == 1 && $current == $alt) $nested--;
            }
            if($nested == 0) break;
        }
        if($nested != 0) return false;

        return $i;
    }

    function parse_variable($str)
    {
        $this->init($str);
        $lexems = ' .:,;?!()[]{}<>-+/*=&^@#$%~\\"\'';
        $word = '';
        $before = $c = '';
        $this->step = 0;
        while($this->step < $this->length)
        {
            $before = $c;
            $c = $this->str[$this->step];
            if(strpos($lexems, $c) !== false)
            {
                if($word != '')
                {
                    if(is_numeric($word)) $this->save($word, 'd');
                    else $this->save($word, 'w');
                }

                if($c == '"' || $c == "'")
                {

                    $i = $this->find_close($this->step, $c, $c);
                    if($i === false)
                    {
                        $this->error .= 'Cannot find the end of the string, '.$c." - expected\n";
                        return 'exit';
                    }
                    else
                    {
                        $word = substr($this->str, $this->step,
                            $i - $this->step + 1);
                        $this->save($word, 's');
                        $word = '';
                        $this->step = $i;
                    }
                }
                else if($c == '(')
                {
                    $this->save('(', '(');
                    $i = $this->find_close($this->step, '(', ')');
                    if($i === false)
                    {
                        $this->error.= "Cannot find the end of the string, ) - expected\n";
                        return false;
                    }
                    else
                    {
                        do
                        {
                            $i2 = $this->find_close($this->step, '(', ')', ',');
                            $word = substr($this->str, $this->step + 1,
                                $i2 - $this->step - 1);
                            $this->save($word, 'e');

                            $word = '';
                            $this->step = $i2;
                            if($i2 < $i) $this->save(',', ',');
                        }while($i2 < $i);
                        $this->save(')', ')');
                    }
                }
                else
                {
                    $word = '';
                    if($c != ' ' || ($c == ' ' && $before != $c))
                            $this->save($c, $c);
                }
            }
            else $word.=$c;
            $this->step++;
        }

        if($word != '')
        {
            if(is_numeric($word)) $this->save($word, 'd');
            else $this->save($word, 'w');
        }
        return $this->rez;
    }

}

// end of class gekkon_lexer ---------------------------------------------------