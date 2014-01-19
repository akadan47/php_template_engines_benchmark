<?php
//Template engine Gekkon
//v3.15 - free edition
//written by Popov Maxim mail@ecto.ru
//http://ecto.ru/projects/gekkon/

class Gekkon
{
var $template_path;
var $bin_path;
var $gekkon_path;
var $data;
var $plugin;
var $ukey;

//constructor
function Gekkon($bin_path, $tpl_path)
{
    $this->bin_path = $bin_path;
    $this->template_path = $tpl_path;
    $this->gekkon_path = dirname(__file__).'/';
    $this->data=array();
    $this->plugin=array();
    $this->ukey=0;
    $this->data['ukey']=&$this->ukey;
}

function get_ukey()
{
$this->ukey++;
return $this->ukey;
}

function add_plugin($name,$close='1',$compile='1',$st_arg='1')
{
$this->plugin[$name]['close']=$close;
if($close=='0')$compile='0';
$this->plugin[$name]['compile']=$compile;
$this->plugin[$name]['st_arg']=$st_arg;

}
//registration variable for using
function register($name,$value)
{
$this->data[$name]=$value;
}

function registers($name,&$value)
{
$this->data[$name]=&$value;
}


function fullTemplatePath($template_name)
{
return $this->template_path.$template_name;
}

function fullBinPath($template_name)
{
return $this->bin_path.$this->binDir($template_name).basename($template_name).'.php';
}

function binDir($template_name)
{
return crc32($this->template_path.$template_name).'/';
}

function display($file_name)
{
if(GEKKON_TRACE==1)echo 'Gekkon: display '.$file_name.' bin:'.$this->binDir($file_name);

$tfile_name=$this->fullTemplatePath($file_name);
$bin_file_name=$this->fullBinPath($file_name);

if(!is_file($tfile_name))
$virt=1;
else
$virt=0;

if(!is_file($bin_file_name) && $virt==1)
{
die('Gekkon: file '.$tfile_name.' does not exist');
return 0;
}

if($virt==0)
{
$lmt=filemtime($tfile_name);
if(is_file($bin_file_name))
$lmb=filemtime($bin_file_name);
else
$lmb=0;
if($lmt>$lmb)
$this->compile_file($file_name);
}
$this->execute($bin_file_name,$file_name);
return 1;
}

function display_into($file_name)
{
ob_start();
ob_clean();
$this->display($file_name);
$r=ob_get_contents();
ob_end_clean();
return $r;
}

function execute($bin_name,$template_name)
{
global $Gekkon;
$data=array();
include $bin_name;

}

function clear_cache($template_name)
{
if(GEKKON_TRACE==1) echo 'Gekkon: clear_cache '.$template_name;

$compile_path=$this->bin_path.$this->binDir($template_name);

if(!is_dir($compile_path))
mkdir(substr($compile_path,0,-1));
else
{
	$dir=dirname($compile_path);
	if ($dh = opendir($compile_path))
	{
	   while (($file = readdir($dh)) !== false)
	      if($file[0]!='.')unlink($compile_path.$file);
	   closedir($dh);
	}
}
}

function compile_file($file_name,$virt_name='')
{
if(GEKKON_TRACE==1) echo 'Gekkon: compile_file '.$file_name.' '.$virt_name;

if($virt_name=='')$virt_name=$file_name;

include_once $this->gekkon_path.'config.php';

$template_text=file_get_contents($this->fullTemplatePath($file_name));

$bin=$this->compile($template_text);

$compile_path=$this->bin_path.$this->binDir($virt_name);
$this->clear_cache($virt_name);
$bfile=fopen($this->fullBinPath($virt_name),'w');
fwrite($bfile,$bin);
fclose($bfile);
}

function compile(&$str)
{
include_once $this->gekkon_path.'config.php';

$str=preg_replace('/{([\$@][^}]+)}/Uis','<!--echo \1-->',$str);

$rez=$this->compile_r($str);
$rez=str_replace('?><?php','',$rez);
$rez=str_replace("?>\r\n<?php","\r\n",$rez);
$rez=str_replace("?>\n<?php","\n",$rez);

return $rez;
}

function compile_r(&$str)
{
if($str=='')return '';

if(!preg_match('/<!--\s*([^\s]+)\b(.*)-->/sU',$str,$arr))return $str;

$tag_pos=strpos($str,$arr[0]);
$tag_len=strlen($arr[0]);
$before_tag=substr($str,0,$tag_pos);
$tag=array();
$tag['name']=trim($arr[1]);
$tag['arg']=trim($arr[2]);
if($tag['name'][0]=='/')
die('Gekkon: compile error, dont open tag bloc - '.$arr[1].$arr[2]);


if(!isset($this->plugin[$tag['name']]))
$tag['name']='comment';
//die('Compile error: Dont know tag - '.$tag['name']);

$tag['compile']=$this->plugin[$tag['name']]['compile'];
$tag['inner']='';
if($this->plugin[$tag['name']]['st_arg']==1)
$tag['arg']=parse_arg($tag['arg']);


if($this->plugin[$tag['name']]['close']==1)
{
$now=$tag_pos;

preg_match_all('/<!--\s*'.$tag['name'].'\b/Us',$str,$m1,PREG_OFFSET_CAPTURE);
preg_match_all('/<!--\s*\/'.$tag['name'].'\s*-->/Us',$str,$m2,PREG_OFFSET_CAPTURE);
$r=array();
foreach($m1[0] as $item)
{
if($item[1]>$now)
{
$r[$item[1]]['type']=1;
$r[$item[1]]['len']=strlen($item[0]);
}
}

foreach($m2[0] as $item)
{
if($item[1]>$now)
{
$r[$item[1]]['type']=-1;
$r[$item[1]]['len']=strlen($item[0]);
}
}

ksort($r);
$f=1;
foreach($r as $pos=>$item)
{
$f+=$item['type'];
if($f==0)
{
$now=$pos;
$end_len=$item['len'];
break;
}
}
if($f!=0)
die('Gekkon: compile error: Dont close tag '.$tag['name']);


$tag['inner']=substr($str,$tag_pos+$tag_len,$now-$tag_pos-$tag_len);


$after_tag=substr($str,$now+$end_len);

}
else
$after_tag=substr($str,$tag_pos+$tag_len);


return $before_tag.$this->compile_tag($tag).$this->compile_r($after_tag);

}


function compile_tag($tag)
{
$bin_open='';
$bin_close='';
include $this->gekkon_path.'plugin/'.$tag['name'].'.php';
if($tag['compile']==1)
$tag['inner']=$this->compile_r($tag['inner']);
return $bin_open.$tag['inner'].$bin_close;
}

}
//-----------------------------------------------------------------------------

function parse_arg($str)
{
//echo '<b>Gekkon debug</b> parse_arg - '.$str.'<br>';
$now=0;
$par=array();
$len=strlen($str)-1;
while($now<$len)
{
$t1=strpos($str,'=',$now);
$name=trim(substr($str,$now,$t1-$now));
while($str[++$t1]==' ');
if($str[$t1]=='"'||$str[$t1]=="'")$find=$str[$t1++];else $find=' ';
$now=strpos($str,$find,$t1);
if($now === false)$now=$len+1;
$val=substr($str,$t1,$now++-$t1);
if($find==' '&&($val[0]=='$'||$val[0]=='@'))
$val=parse_var($val);
else
$val='"'.$val.'"';
$par[$name]=$val;
}
return $par;
}

function parse_var($str)
{
//echo '<b>Gekkon debug</b> parse_var - '.$str.'<br>';
if($str[0]!='$'&&$str[0]!='@')
{if($str[0]=="'"||$str[0]=='"')return $str; else return "'$str'";}

$len=strlen($str);
if($len==1)return $str;
$now=0;
$ret='';
$p=0;
$ff=1;
$e=$len;

$t=strpos($str,'.');
if($t !== false ){$e=$t;$ff=1;}
$t=strpos($str,'->');
if($t !== false )if($t<$e){$e=$t;$ff=2;$p=1;}
if($str[0]=='@')
$ret='$data["'.substr($str,1,$e-1).'"]';
else
$ret='$this->data["'.substr($str,1,$e-1).'"]';


$now=$e;

while($now<$len)
{
	$now++;
	if($p==1)$now++;

	$e=$len;
	$p=0;$f=$ff;
	$t=strpos($str,'.',$now);
	if($t !== false ){$e=$t;$ff=1;}
	$t=strpos($str,'->',$now);
	if($t !== false )if($t<$e){$e=$t;$p=1;$ff=2;}



	$v=substr($str,$now,$e-$now);
	if($f==1)
	{
		$t=strpos($v,'(');
		if($t !== false)
		{
			$vv=substr($v,0,$t);
			$tt=strpos($v,')');

			if($tt-$t-1>0)
			$ret="$vv($ret,".parse_var(substr($v,$t+1,$tt-$t-1)).")";
			else
			$ret="$vv($ret)";
		}
		else
		{
			$vv=explode('&',$v);
			$t=parse_var($vv[0]);
			$c=count($vv);
			for($i=1;$i<$c;$i++)
			{
			$t.='['.parse_var($vv[$i]).']';
			}
			$ret.="[$t]";
		}
	}
	if($f==2)
	{
	$ret.='->'.$v;
	}
	$now=$e;

}

return $ret;
}

/**/
?>