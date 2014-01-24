<?php

include_once 'gekkon.php';
Gekkon::include_dir('compiler');

define('R_DEBUG', 1);
ini_set("display_errors", 'on');




$vars = array(
    '1+1',
    '1++1',
    '1.t()',
    '$a.x(1+1) +($b.x(1+")"+ 1)+g)*(1).tt()',
    '$a.x(1+1) +(3+4)*(1+2)',
    '$str',
    '$str.index',
    '@aaa.bbb()',
    '$str.$index',
    '$str.index.index2',
    '$str.$index.index2."ad \"as"',
    '$str.$index.@index2',
    '$str.($index.index2)',
    '$str.($index.index2.func("asd"))',
    '$str.($index.index2.func()).func2()',
    '$str.($index.index2).index3',
    '$str.($index.index2).@index3',
    '$str.($index.index2).$index3.$idx',
    '$str.($index.index2).index3.func()',
    '$str.($index.index2).$index3.func().func2()',
    '$str.$index.index2.func()->asd.func2()',
    '$str.($index.index2.func()->asd).func2()',
    '$str.($index.index2.func()->asd()).func2()',
    '$str.($index.index2).(($index3.index4)->method1()->prop1.func()).func2()',
    '$aaa.bbb(111)',
    '$aaa.bbb(111).ccc()',
    '$aaa.bbb(111).ccc(222)',
    '$aaa.bbb(111,333).ccc()',
    '$aaa.bbb(111,333).ccc(222,444)',
    '$aaa.bbb($ccc)',
    '$aaa.bbb($ccc,ddd)',
    '$aaa.bbb($ccc.ddd)',
    '$aaa.bbb($ccc.bbb(111))',
    '$aaa.bbb(111,333).ccc($aaa.bbb($aaa.bbb(111)),444)',
    '$aaa.bbb($ccc.bbb(111))->method(param)->prop.func(1)',
    '$aaa.bbb($ccc.bbb(111),$fff.bbb($ggg.bbb(111)))->method(param,param2,$jjj.bbb($aaa.bbb(111)))->prop.funcF($str.($index.index2).(($index3.index4)->method1()->prop1.func()).func2())',
    '$aaa.bbb(111).123',
    '$aaa.bbb(111).123.ccc()',
    'reactor::$min',
    'reactor::$min.111',
    'reactor::$min.',
    'reactor::$min->aaa',
    'reactor::$min->aaa()',
    'reactor::$min->aaa(bbb)',
    'reactor::$min->aaa($bbb.ccc)',
    'reactor::$min->asda().aaa()',
    'reactor::$min->asda(xxx).aaa()',
    'reactor::$min->asda($bbb.nnn).aaa($ccx)',
    'reactor::min()',
    'reactor::min(123)',
    'reactor::min(aaa)',
    'reactor::min($aaa.bbb)',
    'reactor::min()->aaa',
    'reactor::min(123)->asd',
    'reactor::min(aaa)->ddd()',
    'reactor::min($aaa.bbb)->nnn()',
    'reactor::min($aaa.bbb)->nnn(rr::mox()).hhh(rr::$max)',
    '$aaa.rrr::$bbb',
    '$aaa.rrr::bbb()',
    '$aaa.rrr::bbb($ccc)',
    '$ddd.111.222',
    '$ddd.(111.222)',
    '$ddd.(((111.222)))',
    '$ddd.fff(111.222)',
    '$ddd.bbb(111,333).ccc()',
    '$ddd.bbb(111.333).ccc(111,222.333)',
    '"String with \"spaces"',
    "'String with \'spaces'",
    '"String with \"spaces".toLow()',
    "'String with \'spaces'.toLow()",
    "'test'.ttt()",
    'index',
    'ff.pow()',
    '5',
    '1.5',
    '7.pow()',
    '7.7.pow()',
    '7.pow(2)',
    '7.pow(2).pow(3)',
    '(7.7).pow(2)',
    'pow(22)',
    'pow(22,66)',
    'pow(22).trr(11)',
    '$tt.5',
    '$tt.5.6',
    '$tt.(5.6)',
    '@',
    '$', //will be an error
    '$.',
    '.',
    '',
    '$.asd',
        /* */
);






$gekkon = new Gekkon('', '', '');

$g_compiler = new GekkonCompiler($gekkon);



//print_r($g_compiler->arg_compiler->parser->parse(gekkon_lexer('7.pow()'))->real());


$lx = new GekkonLexer();
/*

  //die('ok');
  for($j = 0; $j < $cnt; $j++)
  {
  echo $vars[$j], "<br>\n";
  if(($x = $g_compiler->exp_compiler->compile_exp($vars[$j])) === false)
  $g_compiler->flush_errors();

  echo $x, "<br><br>\n\n";
  //print_r($lx->parse_variable($vars[$j]));
  //echo $lx->error;
  }

  print_r($lx->parse_construction($lx->parse_expression('from=$asd.sd item=$asd meta=$loop'),
  array('from', '=', '<exp>', 'item', '=', '<exp>', 'meta', '=', '<exp>')));
  echo $lx->error;

  /* */




//$vars = array('reactor::$min->aaa(bbb)');

$cnt = count($vars);
/*
  for($j = 0; $j < $cnt; $j++)
  {
  echo $vars[$j], "<br>\n";
  $rez = $g_compiler->exp_compiler->arg_compiler->parser->parse($lx->parse_variable($vars[$j]));
  if($rez !== false)
  {
  print_r($rez->real());
  }
  else
  echo $pr->error, '<br><br>';  //print_r($lx->parse_variable($vars[$j]));

  }

  /* */
//print_r($g_compiler);
for($j = 0; $j < $cnt; $j++)
{
    echo $vars[$j], "<br>\n";
    if(($x = $g_compiler->exp_compiler->compile_exp($vars[$j])) === false)
    {
        $g_compiler->flush_errors();
    }
    else echo $x, "<br><br>\n\n";
    //print_r($lx->parse_variable($vars[$j]));
    //echo $lx->error;
}

