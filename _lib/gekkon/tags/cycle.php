<?php

function gekkon_tag_cycle_single($compiler, $_tag)
{
    $exp_compiler = &$compiler->exp_compiler;
    if(($args = $exp_compiler->parse_expression($_tag['raw_args'])) === false)
            return $compiler->error_in_tag('Cannot parse args "'.$_tag['raw_args'].'"',
                $_tag);

    $args = $exp_compiler->split($args, ';');
    $values = $exp_compiler->split($args[0]['v'], ',');

    if(($values = $exp_compiler->compile_construction_expressions($values)) === false)
            return $compiler->error_in_tag('Cannot compile args "'.$_tag['raw_args'].'"',
                $_tag);

    $rez = '';
    if(!isset($args[1])) $variable = '$_gkn_cycle'.$compiler->getUID();
    else
    {
        if(($variable = $exp_compiler->compile_parsed_exp($args[1]['v'])) === false)
                return $compiler->error_in_tag('Cannot compile args "'.$_tag['raw_args'].'"',
                    $_tag);
    }
    $rez.= "if(!isset(".$variable.")||!is_array(".$variable.")){\n";
    $rez.= $variable."=array('data'=>array(";
    foreach($values as $item) $rez.= $item.",";
    $rez.= ")\n,'current'=>0);}\n";
    $rez.= "echo ".$variable."['data'][".$variable."['current']++];\n";
    $rez.= 'if('.$variable."['current']===count(".$variable."['data']))".$variable."['current'] = 0;\n";

    return $rez;
}

?>
