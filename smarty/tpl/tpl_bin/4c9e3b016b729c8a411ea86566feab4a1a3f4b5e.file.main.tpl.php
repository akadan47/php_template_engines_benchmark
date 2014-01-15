<?php /* Smarty version Smarty-3.1.16, created on 2014-01-15 02:53:49
         compiled from "./tpl/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:39200156952d2dfdac39113-01892924%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4c9e3b016b729c8a411ea86566feab4a1a3f4b5e' => 
    array (
      0 => './tpl/main.tpl',
      1 => 1389740028,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '39200156952d2dfdac39113-01892924',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_52d2dfdad03151_91986969',
  'variables' => 
  array (
    'shop_name' => 0,
    'menu_list' => 0,
    'menu_item' => 0,
    'tizer_list' => 0,
    'tizer' => 0,
    'vendor_list' => 0,
    'vendor' => 0,
    'good' => 0,
    'online' => 0,
    'user' => 0,
    'title' => 0,
    'image' => 0,
    'model' => 0,
    'detail' => 0,
    'property' => 0,
    'value' => 0,
    'comments' => 0,
    'comment' => 0,
    'blog_posts' => 0,
    'post' => 0,
    'news_list' => 0,
    'article' => 0,
    'tag' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d2dfdad03151_91986969')) {function content_52d2dfdad03151_91986969($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_capitalize')) include '/Users/denis/Work/Projects/te_bench/_lib/smarty/plugins/modifier.capitalize.php';
if (!is_callable('smarty_function_cycle')) include '/Users/denis/Work/Projects/te_bench/_lib/smarty/plugins/function.cycle.php';
?><!doctype html>
<html><head><meta charset="utf-8"><title><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['shop_name']->value);?>
</title><link rel="stylesheet" href="/css/page.css"></head><body><div id="layout"><header><h2><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['shop_name']->value);?>
</h2><br/><nav><ul><?php  $_smarty_tpl->tpl_vars['menu_item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu_item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu_item']->key => $_smarty_tpl->tpl_vars['menu_item']->value) {
$_smarty_tpl->tpl_vars['menu_item']->_loop = true;
?><li<?php if ($_smarty_tpl->tpl_vars['menu_item']->value['current']) {?> class="current"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['menu_item']->value['url'];?>
"><?php if ($_smarty_tpl->tpl_vars['menu_item']->value['current']) {?><b><?php echo ucfirst($_smarty_tpl->tpl_vars['menu_item']->value['name']);?>
</b><?php } else { ?><?php echo ucfirst($_smarty_tpl->tpl_vars['menu_item']->value['name']);?>
<?php }?></a></li><?php } ?></ul></nav></header><section id="tizers"><table><tr><?php  $_smarty_tpl->tpl_vars['tizer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tizer']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tizer_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tizer']->key => $_smarty_tpl->tpl_vars['tizer']->value) {
$_smarty_tpl->tpl_vars['tizer']->_loop = true;
?><td><a href="<?php echo $_smarty_tpl->tpl_vars['tizer']->value['url'];?>
"><?php echo ucfirst($_smarty_tpl->tpl_vars['tizer']->value['text']);?>
</a></td><?php } ?></tr></table></section><hr/><main><table><tr><td id="left"><section id="vendors"><h4>Vendors:</h4><ul><?php  $_smarty_tpl->tpl_vars['vendor'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vendor']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vendor_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vendor']->key => $_smarty_tpl->tpl_vars['vendor']->value) {
$_smarty_tpl->tpl_vars['vendor']->_loop = true;
?><li<?php if ($_smarty_tpl->tpl_vars['vendor']->value['id']==$_smarty_tpl->tpl_vars['good']->value['vendor']['id']) {?> class="current"<?php }?>><a href="#vendor_<?php echo $_smarty_tpl->tpl_vars['vendor']->value['id'];?>
.html"><?php echo ucfirst($_smarty_tpl->tpl_vars['vendor']->value['name']);?>
</a></li><?php } ?></ul></section><br/><br/><section id="online"><h4>Online users (<?php echo $_smarty_tpl->tpl_vars['online']->value['count'];?>
):</h4><?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['online']->value['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['user']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['user']->iteration=0;
 $_smarty_tpl->tpl_vars['user']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->_loop = true;
 $_smarty_tpl->tpl_vars['user']->iteration++;
 $_smarty_tpl->tpl_vars['user']->index++;
 $_smarty_tpl->tpl_vars['user']->first = $_smarty_tpl->tpl_vars['user']->index === 0;
 $_smarty_tpl->tpl_vars['user']->last = $_smarty_tpl->tpl_vars['user']->iteration === $_smarty_tpl->tpl_vars['user']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['first'] = $_smarty_tpl->tpl_vars['user']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['last'] = $_smarty_tpl->tpl_vars['user']->last;
?><span><a href="#profile/user.html?id=<?php echo $_smarty_tpl->tpl_vars['user']->value[0];?>
"><?php echo $_smarty_tpl->tpl_vars['user']->value[1];?>
</a><?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['loop']['last']) {?>, <?php } else { ?>.<?php }?></span><?php } ?></section></td><td id="center"><?php $_smarty_tpl->tpl_vars['good'] = new Smarty_variable($_smarty_tpl->tpl_vars['good']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['good']->value['vendor']['name'])." ".((string)$_smarty_tpl->tpl_vars['good']->value['name']), null, 0);?><h1><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['good']->value['model']) {?>(<?php echo $_smarty_tpl->tpl_vars['good']->value['model'];?>
)<?php }?></h1><span><b>Color:</b> <?php echo $_smarty_tpl->tpl_vars['good']->value['color'];?>
, <b>Warranty:</b> <?php echo $_smarty_tpl->tpl_vars['good']->value['warranty'];?>
, <b>Country:</b> <?php echo $_smarty_tpl->tpl_vars['good']->value['country'];?>
</span><br/><br/><table id="good_layout"><tr><td><section id="good_image"><div id="good_image_main"><img src="<?php echo $_smarty_tpl->tpl_vars['good']->value['images'][0];?>
" alt=""/></div><div id="good_image_list"><?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['good']->value['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['image']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['image']->iteration=0;
 $_smarty_tpl->tpl_vars['image']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value) {
$_smarty_tpl->tpl_vars['image']->_loop = true;
 $_smarty_tpl->tpl_vars['image']->iteration++;
 $_smarty_tpl->tpl_vars['image']->index++;
 $_smarty_tpl->tpl_vars['image']->first = $_smarty_tpl->tpl_vars['image']->index === 0;
 $_smarty_tpl->tpl_vars['image']->last = $_smarty_tpl->tpl_vars['image']->iteration === $_smarty_tpl->tpl_vars['image']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['first'] = $_smarty_tpl->tpl_vars['image']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['last'] = $_smarty_tpl->tpl_vars['image']->last;
?><?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['loop']['first']) {?><a href="#<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['loop']['iteration'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value;?>
" alt=""/></a><?php }?><?php } ?><div style="clear: both"></div></div></section><br/><br/><section id="models"><b>Other models</b><ul><?php  $_smarty_tpl->tpl_vars['model'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['model']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['good']->value['model_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['model']->key => $_smarty_tpl->tpl_vars['model']->value) {
$_smarty_tpl->tpl_vars['model']->_loop = true;
?><li><a href="<?php echo $_smarty_tpl->tpl_vars['model']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['model']->value['name'];?>
</a></li><?php } ?></ul></section></td><td><section id="price"><b>Price:</b> $<?php echo $_smarty_tpl->tpl_vars['good']->value['price'];?>
 (<s>$<?php echo $_smarty_tpl->tpl_vars['good']->value['price_old'];?>
</s>) <button>Buy</button></section><br/><br/><section id="details"><h3>Details</h3><br/><ul><?php  $_smarty_tpl->tpl_vars['detail'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['detail']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['good']->value['short_details']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['detail']->key => $_smarty_tpl->tpl_vars['detail']->value) {
$_smarty_tpl->tpl_vars['detail']->_loop = true;
?><li><?php echo $_smarty_tpl->tpl_vars['detail']->value;?>
</li><?php } ?></ul></section><br/><section id="tech_spec"><h3>Tech spec:</h3><table><?php  $_smarty_tpl->tpl_vars['property'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['property']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['good']->value['props']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['property']->key => $_smarty_tpl->tpl_vars['property']->value) {
$_smarty_tpl->tpl_vars['property']->_loop = true;
?><tr><?php if ($_smarty_tpl->tpl_vars['property']->value['type']=='category') {?><td colspan="2" class="category"><b><?php echo ucfirst(mb_strtolower($_smarty_tpl->tpl_vars['property']->value['value'], 'UTF-8'));?>
</b></td><?php } elseif ($_smarty_tpl->tpl_vars['property']->value['type']=='bool') {?><td><?php echo ucfirst($_smarty_tpl->tpl_vars['property']->value['name']);?>
</td><td><?php if ($_smarty_tpl->tpl_vars['property']->value['value']) {?>Yes<?php } else { ?>No<?php }?></td><?php } elseif ($_smarty_tpl->tpl_vars['property']->value['type']=='string') {?><td><?php echo ucfirst($_smarty_tpl->tpl_vars['property']->value['name']);?>
</td><td><?php echo $_smarty_tpl->tpl_vars['property']->value['value'];?>
</td><?php } elseif ($_smarty_tpl->tpl_vars['property']->value['type']=='list') {?><td><?php echo ucfirst($_smarty_tpl->tpl_vars['property']->value['name']);?>
</td><td><?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['property']->value['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['value']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['value']->iteration=0;
 $_smarty_tpl->tpl_vars['value']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['value']->iteration++;
 $_smarty_tpl->tpl_vars['value']->index++;
 $_smarty_tpl->tpl_vars['value']->first = $_smarty_tpl->tpl_vars['value']->index === 0;
 $_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['first'] = $_smarty_tpl->tpl_vars['value']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['last'] = $_smarty_tpl->tpl_vars['value']->last;
?><?php echo ucfirst($_smarty_tpl->tpl_vars['value']->value);?>
<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['loop']['last']) {?>, <?php } else { ?>.<?php }?><?php } ?></td><?php }?></tr><?php } ?></table></section></td></tr></table><br/><section id="comments"><h2>Comments (<?php echo $_smarty_tpl->tpl_vars['comments']->value['count'];?>
)</h2><br/><ul><?php  $_smarty_tpl->tpl_vars['comment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['comment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comments']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['comment']->key => $_smarty_tpl->tpl_vars['comment']->value) {
$_smarty_tpl->tpl_vars['comment']->_loop = true;
?><li><b><?php echo $_smarty_tpl->tpl_vars['comment']->value['user'];?>
</b>, <span class="date"><?php echo $_smarty_tpl->tpl_vars['comment']->value['date']->format('m/d/Y');?>
</span><p><?php echo $_smarty_tpl->tpl_vars['comment']->value['text'];?>
</p></li><?php } ?></ul></section></td><td id="right"><section id="blog"><h3>Blog</h3><br/><ul><?php  $_smarty_tpl->tpl_vars['post'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['post']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['blog_posts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['post']->key => $_smarty_tpl->tpl_vars['post']->value) {
$_smarty_tpl->tpl_vars['post']->_loop = true;
?><li><?php echo $_smarty_tpl->tpl_vars['post']->value['date']->format('m/d/Y');?>
 <br/> <a href="#blog_<?php echo $_smarty_tpl->tpl_vars['post']->value['id'];?>
.html"><?php echo $_smarty_tpl->tpl_vars['post']->value['title'];?>
</a></li><br/><?php } ?></ul></section><br/><section id="news"><h3>Recent News</h3><table><?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['news_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
?><tr class="<?php echo smarty_function_cycle(array('values'=>"white, grey"),$_smarty_tpl);?>
"><td><h4><a href="#news_<?php echo $_smarty_tpl->tpl_vars['article']->value['id'];?>
.html"><?php echo $_smarty_tpl->tpl_vars['article']->value['title'];?>
</a></h4><span class="date"><?php echo $_smarty_tpl->tpl_vars['article']->value['date']->format('m/d/Y');?>
</span><span class="lead"><?php echo $_smarty_tpl->tpl_vars['article']->value['lead'];?>
</span><span class="tags">Tags: <?php  $_smarty_tpl->tpl_vars['tag'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tag']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['article']->value['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['tag']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['tag']->iteration=0;
 $_smarty_tpl->tpl_vars['tag']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['tag']->key => $_smarty_tpl->tpl_vars['tag']->value) {
$_smarty_tpl->tpl_vars['tag']->_loop = true;
 $_smarty_tpl->tpl_vars['tag']->iteration++;
 $_smarty_tpl->tpl_vars['tag']->index++;
 $_smarty_tpl->tpl_vars['tag']->first = $_smarty_tpl->tpl_vars['tag']->index === 0;
 $_smarty_tpl->tpl_vars['tag']->last = $_smarty_tpl->tpl_vars['tag']->iteration === $_smarty_tpl->tpl_vars['tag']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['first'] = $_smarty_tpl->tpl_vars['tag']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loop']['last'] = $_smarty_tpl->tpl_vars['tag']->last;
?><span><?php echo $_smarty_tpl->tpl_vars['tag']->value;?>
<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['loop']['last']) {?>, <?php } else { ?>.<?php }?></span><?php } ?></span><span>Comments (<?php echo $_smarty_tpl->tpl_vars['article']->value['comments_count'];?>
)</span></td></tr><?php } ?></table></section></td></tr></table></main><footer><h5>&copy; <?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</h5><nav><ul><?php  $_smarty_tpl->tpl_vars['menu_item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu_item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu_item']->key => $_smarty_tpl->tpl_vars['menu_item']->value) {
$_smarty_tpl->tpl_vars['menu_item']->_loop = true;
?><li<?php if ($_smarty_tpl->tpl_vars['menu_item']->value['current']) {?> class="current"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['menu_item']->value['url'];?>
"><?php if ($_smarty_tpl->tpl_vars['menu_item']->value['current']) {?><b><?php echo ucfirst($_smarty_tpl->tpl_vars['menu_item']->value['name']);?>
</b><?php } else { ?><?php echo ucfirst($_smarty_tpl->tpl_vars['menu_item']->value['name']);?>
<?php }?></a></li><?php } ?></ul></nav></footer></div></body></html><?php }} ?>
