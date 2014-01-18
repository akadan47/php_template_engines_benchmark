<?php
$t=explode(' ',$tag['arg']);
$bin_open='<?php switch(';
foreach($t as $tt)
{
if($tt[0]=='$'||$tt[0]=='@')$tt=parse_var($tt);
$bin_open.=$tt;
}
$bin_open.='){ default:?>';


$bin_close='<?php break; } ?>';
?>