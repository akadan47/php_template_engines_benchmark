<?php
if(!isset($tag['arg']['step']))$tag['arg']['step']=1;

if(!isset($tag['arg']['key']))
$tag['arg']['key']=parse_var('$for_key'.$this->get_ukey());

$bin_open='<?php for('.$tag['arg']['key'].'='.$tag['arg']['from'].';'.$tag['arg']['key'].'<'.$tag['arg']['to'].';'.$tag['arg']['key'].'+='.$tag['arg']['step'].'){?>';

$bin_close='<?php } ?>';
?>