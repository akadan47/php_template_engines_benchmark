<?php

class GekkonExpCompiler {

    function __construct(&$compiler)
    {
        $this->compiler = $compiler;
        $this->arg_compiler = new GekkonArgCompiler($this);
        $this->arg_lexer = new GekkonLexer();
    }

    function compile_construction_expressions($data)
    {
        $rez = array();
        foreach($data as $key => $value)
        {
            if($value['t'] == '<exp>')
            {
                $t = $this->compile_parsed_exp($value['v']);
                if($t === false) return false;
                $rez[$key] = $t;
            }
            else $rez[$key] = $value['v'];
        }
        return $rez;
    }

    function compile_exp($str)
    {
        $data = $this->arg_lexer->parse_expression($str);
        if($data === false)
                return $this->compiler->error($this->arg_lexer->error,
                    'arg_lexer');

        return $this->compile_parsed_exp($data);
    }

    function compile_parsed_exp($data)
    {
        $rez = '';
        $orig = '';
        foreach($data as $item)
        {
            if($item['t'] == 'l') $rez.=$item['v'];
            else
            {
                $t = $this->compile_arg($item['v']);
                if($t === false) return false;
                $rez.=$t;
            }
            $orig.=$item['v'];
        }
        if(!$this->check_exp_syntax($rez))
                return $this->compiler->error('Wrong expression syntax "'.$orig.'"',
                    'compile_exp');
        /* */
        return $rez;
    }

    function compile_arg($str)
    {

        $rez = $this->arg_compiler->compile($str);
        if($rez === false)
        {

            $this->compiler->error($this->arg_compiler->error, 'arg_compiler');
            $this->arg_compiler->error = '';
        }
        return $rez;
    }

    function parse_args($_str)
    {
        $_str = explode('=', $_str);
        $_rez = array();
        $cnt = count($_str) - 1;
        $name = trim($_str[0]);
        $i = 1;
        while($i < $cnt)
        {
            $t = strrpos($_str[$i], ' ');
            $val = substr($_str[$i], 0, $t);
            $_rez[$name] = array('t' => '<exp>', 'v' => $this->parse_expression($val));

            $name = trim(substr($_str[$i], $t));
            $i++;
        }
        if(isset($_str[$cnt]))
        {
            $val = $_str[$cnt];
            $_rez[$name] = array('t' => '<exp>', 'v' => $this->parse_expression($val));
        }
        return $_rez;
    }

    function check_syntax($code)
    {
        ob_start();

        $code = 'if(0){'.$code.'}';
        $result = eval($code);
        ob_get_clean();

        return false !== $result;
    }

    function check_exp_syntax($code)
    {
        return GekkonExpCompiler::check_syntax('$x='.$code.';');
    }

    function parse_expression($str)
    {
        if(($rez = $this->arg_lexer->parse_expression($str)) == false)
                $this->compiler->error($this->arg_lexer->error, 'arg_lexer');
        return $rez;
    }

    function parse_construction($data, $keys, $strict = true)
    {
        $current_keyword = 0;
        $rez = array();
        $buffer = array();
        foreach($data as $item)
        {
            if(in_array($item['v'], $keys))
            {
                if(count($buffer) > 0)
                {
                    $rez[] = array('t' => '<exp>', 'v' => $buffer);
                    $current_keyword++;
                    $buffer = array();
                }
                if($item['v'] === $keys[$current_keyword])
                {
                    $rez[] = array('t' => 'k', 'v' => $item['v']);
                    $current_keyword++;
                }
                else
                        return $this->compiler->error('Unxpected keyword '.$item['v'].' '.$keys[$current_keyword],
                            'arg_compiler');
            }
            else
            {
                if($keys[$current_keyword] === '<exp>') $buffer[] = $item;
                else
                        return $this->compiler->error('Keyword "'.$keys[$current_keyword].'" is expected',
                            'arg_compiler');
            }
        }

        if(count($buffer) > 0)
        {
            $rez[] = array('t' => '<exp>', 'v' => $buffer);
            $current_keyword++;
        }
        if($current_keyword < count($keys) - 1 && $strict === true)
                return $this->compiler->error('Keyword "'.$keys[$current_keyword].'" is expected',
                    'arg_compiler');

        return $rez;
    }

    function split($data, $splitter)
    {
        $rez = array();
        $current = 0;
        $buffer = array();
        foreach($data as $item)
        {
            if($item['v'] === $splitter)
            {
                $rez[$current] = array('t' => '<exp>', 'v' => $buffer);
                $current++;
                $buffer = array();
            }
            else $buffer[] = $item;
        }

        if(count($buffer) > 0)
                $rez[$current] = array('t' => '<exp>', 'v' => $buffer);;
        return $rez;
    }

}

// End Of Class ----------------------------------------------------------------



class GekkonArgCompiler {

    function __construct(&$exp_compiler)
    {
        $this->exp_compiler = $exp_compiler;

        $this->parser = new GekkonLLParser(array(
            '<gekkon_var>' => '<object><object_ext> | <non_object><non_object_ext> | w<constant_ext>',
            '<object>' => '$w | @w ',
            '<non_object>' => 's | d<digit_ext> | (e)',
            '<non_object_ext>' => '| .w<function><object_ext>',
            '<digit_ext>' => '| .<double_or_function>',
            '<double_or_function>' => 'd | w<function>',
            '<object_ext>' => '| .<index_or_function_or_static_object><object_ext> | -><object_member>',
            '<constant_ext>' => '<non_object_ext> | <function> | <static_object>',
            '<index_or_function_or_static_object>' => '<object> | s | d | (e)  | w<is_function_or_static_object>',
            '<is_function_or_static_object>' => '| <function> | <static_object>',
            '<function>' => '(<parameters>)<object_ext>',
            '<static_object>' => '::<static_object_member>',
            '<static_object_member>' => '$w<object_ext> | w<function>',
            '<object_member>' => 'w<is_method><object_ext>',
            '<is_method>' => '| (<parameters>)',
            '<parameters>' => '| e<parameters_ext>',
            '<parameters_ext>' => '| ,e<parameters_ext>',
        ));
    }

    function compile($_str)
    {
        $this->error = '';
        $_str = trim($_str);
        if($_str == '') return '';
        if($_str == '@') return '@';

        $_data = $this->exp_compiler->arg_lexer->parse_variable($_str);
        if(($_data = $this->parser->parse($_data)) === false)
        {

            $this->error .= 'Cannot compile '.$_str.'; '.$this->parser->error;
            return false;
        }

        $this->rez = '';
        $this->n_gekkon_var($_data->real());
        if($this->error != '') return false;
        return $this->rez;
    }

    function n_gekkon_var($_data)
    {
        if(isset($_data['<gekkon_var>']))
                $this->n_gekkon_var($_data['<gekkon_var>']);

        if(isset($_data['<object>'])) $this->n_object($_data['<object>']);


        if(isset($_data['<object_ext>']))
                $this->n_object_ext($_data['<object_ext>']);

        if(isset($_data['<non_object>']))
                $this->n_non_object($_data['<non_object>']);

        if(isset($_data['<non_object_ext>']))
                $this->n_non_object_ext($_data['<non_object_ext>']);

        if(isset($_data['w']))
        {
            if(isset($_data['<constant_ext>']))
                    $this->n_constant_ext($_data['<constant_ext>'], $_data['w']);
        }
    }

    function n_object($_data)
    {
        if(isset($_data['$'])) $this->rez .= "\$_gkn_data['".$_data['w']."']";
        if(isset($_data['@'])) $this->rez .= '$'.$_data['w'];
    }

    function n_non_object($_data)
    {
        if(isset($_data['s'])) $this->rez .=$_data['s'];

        if(isset($_data['d'])) $this->rez .=$_data['d'];

        if(isset($_data['<digit_ext>']))
                $this->n_digit_ext($_data['<digit_ext>']);

        if(isset($_data['e'])) $this->t_e($_data['e'], true);
    }

    function n_non_object_ext($_data)
    {
        if(isset($_data['<function>']))
                $this->n_function($_data['<function>'], $_data['w']);

        if(isset($_data['<object_ext>']))
                $this->n_object_ext($_data['<object_ext>']);
    }

    function n_digit_ext($_data)
    {
        if(isset($_data['<double_or_function>']))
                $this->n_double_or_function($_data['<double_or_function>']);
    }

    function n_double_or_function($_data)
    {
        if(isset($_data['d'])) $this->rez .='.'.$_data['d'];
        else
        {
            if(isset($_data['w']))
                    $this->n_function($_data['<function>'], $_data['w']);
        }
    }

    function n_object_ext($_data)
    {
        if(isset($_data['<object_member>']))
        {
            $this->rez .= '->';
            $this->n_object_member($_data['<object_member>']);
        }
        else
        {
            if(isset($_data['<index_or_function_or_static_object>']))
                    $this->n_index_or_function_or_static_object($_data['<index_or_function_or_static_object>']);

            if(isset($_data['<object_ext>']))
                    $this->n_object_ext($_data['<object_ext>']);
        }
    }

    function n_constant_ext($_data, $w)
    {
        if(isset($_data['<static_object>']))
                $this->n_static_object($_data['<static_object>'], $w);
        else if(isset($_data['<function>']))
                $this->n_function($_data['<function>'], $w);
        else
        {
            $this->rez.=$w;
            if(isset($_data['<non_object_ext>']))
                    $this->n_non_object_ext($_data['<non_object_ext>']);
        }
    }

    function n_is_function_or_static_object($_data, $w)
    {
        if(isset($_data['<function>']))
                $this->n_function($_data['<function>'], $w);
        else if(isset($_data['<static_object>']))
        {
            if(isset($_data['<static_object>']['<static_object_member>']['$']))
            {
                $this->rez .= '[';
                $this->n_static_object($_data['<static_object>'], $w);
                $this->rez .= ']';
            }
            else $this->n_static_object($_data['<static_object>'], $w);
        }
    }

    function n_index_or_function_or_static_object($_data)
    {
        if(isset($_data['<is_function_or_static_object>']))
        {
            $this->n_is_function_or_static_object($_data['<is_function_or_static_object>'],
                $_data['w']);
        }
        else
        {
            $this->rez .= '[';

            if(isset($_data['<object>'])) $this->n_object($_data['<object>']);
            else if(isset($_data['s'])) $this->rez .=$_data['s'];
            else if(isset($_data['d'])) $this->rez .=$_data['d'];
            else if(isset($_data['w'])) $this->rez .="'".$_data['w']."'";
            else if(isset($_data['e'])) $this->t_e($_data['e'], true);

            $this->rez .= ']';
        }
    }

    function n_static_object($_data, $w)
    {
        $this->n_static_object_member($_data['<static_object_member>'], $w);
    }

    function n_static_object_member($_data, $w)
    {
        if(isset($_data['$']))
        {
            $this->rez .= $w.'::$'.$_data['w'];
            if(isset($_data['<object_ext>']))
                    $this->n_object_ext($_data['<object_ext>']);
        }
        else
        {
            $this->n_function($_data['<function>'], $w.'::'.$_data['w']);
        }
    }

    function n_object_member($_data)
    {
        if(isset($_data['w'])) $this->rez .= $_data['w'];
        if(isset($_data['<is_method>']))
                $this->n_is_method($_data['<is_method>']);

        if(isset($_data['<object_ext>']))
                $this->n_object_ext($_data['<object_ext>']);
    }

    function n_is_method($_data)
    {

        if(isset($_data['(']))
        {
            $this->rez .= '(';

            if(isset($_data['<parameters>']))
                    $this->n_parameters($_data['<parameters>']);

            $this->rez .= ')';
        }
    }

    function n_parameters($_data)
    {

        if(isset($_data['e'])) $this->t_e($_data['e']);

        if(isset($_data['<parameters_ext>']))
                $this->n_parameters_ext($_data['<parameters_ext>']);
    }

    function n_parameters_ext($_data)
    {
        if(isset($_data['e']))
        {
            $this->rez .= ', ';
            $this->t_e($_data['e']);
        }
        if(isset($_data['<parameters_ext>']))
                $this->n_parameters_ext($_data['<parameters_ext>']);
    }

    function n_function($_data, $fname)
    {
        $tobeWrapped = $this->rez;
        $this->rez = $fname.'('.$tobeWrapped;

        if(isset($_data['<parameters>']))
        {
            if($tobeWrapped != '') $this->rez .= ', ';
            $this->n_parameters($_data['<parameters>']);
        }
        $this->rez .= ')';

        if(isset($_data['<object_ext>']))
                $this->n_object_ext($_data['<object_ext>']);
    }

    function t_e($_data, $scope = false)
    {

        $save_rez = $this->rez;
        $this->rez = '';
        $rez = $this->exp_compiler->compile_exp($_data);
        if($rez === false)
        {

            $this->error .= "Cannot compile sub-expression: $_data\n";
        }
        if($scope === true) $rez = '('.$rez.')';
        $this->rez = $save_rez.$rez;
    }

}

//end of class ----------------------------------------------------