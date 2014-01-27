<?php

class gekkon_tag_cycle extends gekkon_base_tag_single {

    function compile($compiler)
    {
        $exp_compiler = &$compiler->exp_compiler;
        $values = $this->args_raw;
        $variable = '$_gkn_cycle'.$compiler->getUID();

        if(preg_match('/data\s*=/u', $this->args_raw, $preg_data,
                        PREG_OFFSET_CAPTURE))
        {
            $values = substr($this->args_raw, 0, $preg_data[0][1]);
            $args = substr($this->args_raw, $preg_data[0][1]);
            $args = $compiler->exp_compiler->parse_args($args);
            $args = $compiler->exp_compiler->compile_construction_expressions($args);
            if(isset($args['data'])) $variable = $args['data'];
        }

        if(($values = $exp_compiler->parse_expression($values)) === false)
                return $compiler->error_in_tag('Cannot parse args "'.$this->args_raw.'"',
                            $this);
        $values = $exp_compiler->split($values, ',');

        if(($values = $exp_compiler->compile_construction_expressions($values)) === false)
                return $compiler->error_in_tag('Cannot compile args "'.$this->args_raw.'"',
                            $this);

        $rez = '';
        $rez.= "if(!isset(".$variable.")||!is_array(".$variable.")){\n";
        $rez.= $variable."=array('data'=>array(";
        foreach($values as $item) $rez.= $item.",";
        $rez.= ")\n,'current'=>0);}\n";
        $rez.= "echo ".$variable."['data'][".$variable."['current']++];\n";
        $rez.= 'if('.$variable."['current']===count(".$variable."['data']))".$variable."['current'] = 0;\n";

        return $rez;
    }

}

//end of class
