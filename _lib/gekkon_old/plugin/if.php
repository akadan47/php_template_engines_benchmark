<?php
$t=explode(' ',$tag['arg']);
$ifstr='';
foreach($t as $tt)
{
if(isset($tt[0]))
if($tt[0]=='$'||$tt[0]=='@')$tt=parse_var($tt);
$ifstr.=' '.$tt;
}


$bin_open='<?php if('.$ifstr.') { ?>';
$bin_close='<?php } ?>';

?>