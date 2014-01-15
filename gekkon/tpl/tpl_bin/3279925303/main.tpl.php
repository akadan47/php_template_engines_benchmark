<?php

function gekkon__tpl_main_tpl(&$gekkon){
// Template file: /Users/denis/Work/Projects/te_bench/gekkon/tpl/main.tpl
echo '<!doctype html>
';
ob_start();
echo '
<html>
    <head>
        <meta charset="utf-8">
        <title>';
echo ucwords($gekkon->data['data']['shop_name']);
echo '</title>
        <link rel="stylesheet" href="/css/page.css">
    </head>
    <body>
        <div id="layout">

            <header>
                <h2>';
echo ucwords($gekkon->data['data']['shop_name']);
echo '</h2>
                <br/>
                <nav>
                    <ul>
                        ';
if(!empty($gekkon->data['data']['menu_list'])){
foreach($gekkon->data['data']['menu_list'] as $gekkon->data['menu_item']){
echo '
                            <li';
if($gekkon->data['menu_item']['current']){
echo ' class="current"';
}
echo '>
                                <a href="';
echo $gekkon->data['menu_item']['url'];
echo '">
                                    ';
if($gekkon->data['menu_item']['current']){
echo '
                                        <b>';
echo ucfirst($gekkon->data['menu_item']['name']);
echo '</b>
                                    ';
}else{
echo '
                                        ';
echo ucfirst($gekkon->data['menu_item']['name']);
echo '
                                    ';
}
echo '
                                </a>
                            </li>
                        ';
}}
echo '
                    </ul>
                </nav>
            </header>

            <section id="tizers">
                <table>
                    <tr>
                        ';
if(!empty($gekkon->data['data']['tizer_list'])){
foreach($gekkon->data['data']['tizer_list'] as $gekkon->data['tizer']){
echo '
                            <td>
                                <a href="';
echo $gekkon->data['tizer']['url'];
echo '">';
echo $gekkon->data['tizer']['text'];
echo '</a>
                            </td>
                        ';
}}
echo '
                    </tr>
                </table>
            </section>

            <hr/>

            <main>
                <table>
                    <tr>
                        <td id="left">

                            <section id="vendors">
                                <h4>Vendors:</h4>
                                <ul>
                                    ';
if(!empty($gekkon->data['data']['vendor_list'])){
foreach($gekkon->data['data']['vendor_list'] as $gekkon->data['vendor']){
echo '
                                        <li';
if($gekkon->data['vendor']['id']==$gekkon->data['data']['good']['vendor']['id']){
echo ' class="current"';
}
echo '><a href="#vendor_';
echo $gekkon->data['vendor']['id'];
echo '.html">';
echo $gekkon->data['vendor']['name'];
echo '</a></li>
                                    ';
}}
echo '
                                </ul>
                            </section>

                            <br/>
                            <br/>

                            <section id="online">
                                <h4>Online users (';
echo $gekkon->data['data']['online']['count'];
echo '):</h4>
                                ';
$_gkn_temp=count($gekkon->data['data']['online']['users']);
        $gekkon->data['loop']=array(
        'first'=>1,
        'last'=>($_gkn_temp==1?1:0),
        'counter0'=>0,
        'counter'=>1,
        'revcounter0'=>$_gkn_temp-1,
        'revcounter'=>$_gkn_temp,
        'total'=>$_gkn_temp,
        );
if(!empty($gekkon->data['data']['online']['users'])){
foreach($gekkon->data['data']['online']['users'] as $gekkon->data['user']){
echo '
                                    <span><a href="#profile/user.html?id=';
echo $gekkon->data['user'][0];
echo '">';
echo $gekkon->data['user'][1];
echo '</a>';
if(!$gekkon->data['loop']['last']){
echo ', ';
}else{
echo '.';
}
echo '</span>
                                ';

        $gekkon->data['loop']['counter0']=$gekkon->data['loop']['counter']++;
        $gekkon->data['loop']['revcounter']=$gekkon->data['loop']['revcounter0']--;
        $gekkon->data['loop']['first']=0;
        $gekkon->data['loop']['last']=($gekkon->data['loop']['revcounter0']==0?1:0);
        }}
echo '
                            </section>

                        </td>
                        <td id="center">

                            ';
$gekkon->data['good']=$gekkon->data['data']['good'];
echo '
                            ';
$gekkon->data['title']=$gekkon->data['good']['vendor']['name']." ".$gekkon->data['good']['name'];
echo '
                            <h1>';
echo $gekkon->data['title'];
echo ' ';
if($gekkon->data['good']['model']){
echo '(';
echo $gekkon->data['good']['model'];
echo ')';
}
echo '</h1>

                            <span>
                                <b>Color:</b> ';
echo $gekkon->data['good']['color'];
echo ', <b>Warranty:</b> ';
echo $gekkon->data['good']['warranty'];
echo ', <b>Country:</b> ';
echo $gekkon->data['good']['country'];
echo '
                            </span>

                            <br/>
                            <br/>

                            <table id="good_layout">
                                <tr>
                                    <td>

                                        <section id="good_image">
                                            <div id="good_image_main">
                                                <img src="';
echo $gekkon->data['good']['images'][0];
echo '" alt=""/>
                                            </div>
                                            <div id="good_image_list">
                                                ';
$_gkn_temp=count($gekkon->data['good']['images']);
        $gekkon->data['loop']=array(
        'first'=>1,
        'last'=>($_gkn_temp==1?1:0),
        'counter0'=>0,
        'counter'=>1,
        'revcounter0'=>$_gkn_temp-1,
        'revcounter'=>$_gkn_temp,
        'total'=>$_gkn_temp,
        );
if(!empty($gekkon->data['good']['images'])){
foreach($gekkon->data['good']['images'] as $gekkon->data['image']){
echo '
                                                    ';
if(!$gekkon->data['loop']['first']){
echo '
                                                        <a href="#';
echo $gekkon->data['loop']['counter'];
echo '"><img src="';
echo $gekkon->data['image'];
echo '" alt=""/></a>
                                                    ';
}
echo '
                                                ';

        $gekkon->data['loop']['counter0']=$gekkon->data['loop']['counter']++;
        $gekkon->data['loop']['revcounter']=$gekkon->data['loop']['revcounter0']--;
        $gekkon->data['loop']['first']=0;
        $gekkon->data['loop']['last']=($gekkon->data['loop']['revcounter0']==0?1:0);
        }}
echo '
                                                <div style="clear: both"></div>
                                            </div>
                                        </section>

                                        <br/>
                                        <br/>

                                        <section id="models">
                                            <b>Other models</b>
                                            <ul>
                                                ';
if(!empty($gekkon->data['good']['model_list'])){
foreach($gekkon->data['good']['model_list'] as $gekkon->data['model']){
echo '
                                                    <li><a href="';
echo $gekkon->data['model']['url'];
echo '">';
echo $gekkon->data['model']['name'];
echo '</a></li>
                                                ';
}}
echo '
                                            </ul>
                                        </section>

                                    </td>
                                    <td>

                                        <section id="price">
                                            <b>Price:</b> $';
echo $gekkon->data['good']['price'];
echo ' (<s>$';
echo $gekkon->data['good']['price_old'];
echo '</s>) <button>Buy</button>
                                        </section>

                                        <br/>
                                        <br/>

                                        <section id="details">
                                            <h3>Details</h3>
                                            <br/>
                                            <ul>
                                                ';
if(!empty($gekkon->data['good']['short_details'])){
foreach($gekkon->data['good']['short_details'] as $gekkon->data['detail']){
echo '
                                                    <li>';
echo $gekkon->data['detail'];
echo '</li>
                                                ';
}}
echo '
                                            </ul>
                                        </section>

                                        <br/>

                                        <section id="tech_spec">
                                            <h3>Tech spec:</h3>
                                            <table>
                                                ';
if(!empty($gekkon->data['good']['props'])){
foreach($gekkon->data['good']['props'] as $gekkon->data['property']){
echo '
                                                    <tr>
                                                        ';
if($gekkon->data['property']['type']=='category'){
echo '
                                                            <td colspan="2" class="category"><b>';
echo ucfirst(strtolower($gekkon->data['property']['value']));
echo '</b></td>
                                                        ';
}elseif($gekkon->data['property']['type']=='bool'){
echo '
                                                            <td>';
echo ucfirst($gekkon->data['property']['name']);
echo '</td>
                                                            <td>';
if($gekkon->data['property']['value']){
echo 'Yes';
}else{
echo 'No';
}
echo '</td>
                                                        ';
}elseif($gekkon->data['property']['type']=='string'){
echo '
                                                            <td>';
echo ucfirst($gekkon->data['property']['name']);
echo '</td>
                                                            <td>';
echo $gekkon->data['property']['value'];
echo '</td>
                                                        ';
}elseif($gekkon->data['property']['type']=='list'){
echo '
                                                            <td>';
echo ucfirst($gekkon->data['property']['name']);
echo '</td>
                                                            <td>
                                                                ';
$_gkn_temp=count($gekkon->data['property']['value']);
        $gekkon->data['loop']=array(
        'first'=>1,
        'last'=>($_gkn_temp==1?1:0),
        'counter0'=>0,
        'counter'=>1,
        'revcounter0'=>$_gkn_temp-1,
        'revcounter'=>$_gkn_temp,
        'total'=>$_gkn_temp,
        );
if(!empty($gekkon->data['property']['value'])){
foreach($gekkon->data['property']['value'] as $gekkon->data['value']){
echo '
                                                                    ';
echo $gekkon->data['value'];
if(!$gekkon->data['loop']['last']){
echo ',';
}else{
echo '.';
}
echo '
                                                                ';

        $gekkon->data['loop']['counter0']=$gekkon->data['loop']['counter']++;
        $gekkon->data['loop']['revcounter']=$gekkon->data['loop']['revcounter0']--;
        $gekkon->data['loop']['first']=0;
        $gekkon->data['loop']['last']=($gekkon->data['loop']['revcounter0']==0?1:0);
        }}
echo '
                                                            </td>
                                                        ';
}
echo '
                                                    </tr>
                                                ';
}}
echo '
                                            </table>
                                        </section>

                                    </td>
                                </tr>
                            </table>

                            <br/>

                            <section id="comments">
                                <h2>Comments (';
echo $gekkon->data['data']['comments']['count'];
echo ')</h2>
                                <br/>
                                <ul>
                                    ';
if(!empty($gekkon->data['data']['comments']['list'])){
foreach($gekkon->data['data']['comments']['list'] as $gekkon->data['comment']){
echo '
                                        <li>
                                            <b>';
echo $gekkon->data['comment']['user'];
echo '</b>, <span class="date">';
echo $gekkon->data['comment']['date']->format('m/d/Y');
echo '</span>
                                            <p>
                                                ';
echo $gekkon->data['comment']['text'];
echo '
                                            </p>
                                        </li>
                                    ';
}}
echo '
                                </ul>
                            </section>

                        </td>
                        <td id="right">

                            <section id="blog">
                                <h3>Blog</h3>
                                <br/>
                                <ul>
                                    ';
if(!empty($gekkon->data['data']['blog_posts'])){
foreach($gekkon->data['data']['blog_posts'] as $gekkon->data['post']){
echo '
                                        <li>';
echo $gekkon->data['post']['date']->format('m/d/Y');
echo ' <br/> <a href="#blog_';
echo $gekkon->data['post']['id'];
echo '.html">';
echo $gekkon->data['post']['title'];
echo '</a></li>
                                        <br/>
                                    ';
}}
echo '
                                </ul>
                            </section>

                            <br/>

                            <section id="news">
                                <h3>Recent News</h3>
                                <table>
                                    ';
if(!empty($gekkon->data['data']['news_list'])){
foreach($gekkon->data['data']['news_list'] as $gekkon->data['article']){
echo '
                                        <tr class="';
if(!isset($_gkn_cycle1)||!is_array($_gkn_cycle1)){
$_gkn_cycle1=array('data'=>array("white","grey",)
,'current'=>0);}
echo $_gkn_cycle1['data'][$_gkn_cycle1['current']++];
if($_gkn_cycle1['current']===count($_gkn_cycle1['data']))$_gkn_cycle1['current'] = 0;
echo '">
                                            <td>
                                                <h4><a href="#news_';
echo $gekkon->data['article']['id'];
echo '.html">';
echo $gekkon->data['article']['title'];
echo '</a></h4>
                                                <span class="date">';
echo $gekkon->data['article']['date']->format('m/d/Y');
echo '</span>
                                                <span class="lead">';
echo $gekkon->data['article']['lead'];
echo '</span>
                                        <span class="tags">
                                            Tags:
                                            ';
$_gkn_temp=count($gekkon->data['article']['tags']);
        $gekkon->data['loop']=array(
        'first'=>1,
        'last'=>($_gkn_temp==1?1:0),
        'counter0'=>0,
        'counter'=>1,
        'revcounter0'=>$_gkn_temp-1,
        'revcounter'=>$_gkn_temp,
        'total'=>$_gkn_temp,
        );
if(!empty($gekkon->data['article']['tags'])){
foreach($gekkon->data['article']['tags'] as $gekkon->data['tag']){
echo '
                                                <span>';
echo $gekkon->data['tag'];
if(!$gekkon->data['loop']['last']){
echo ', ';
}else{
echo '.';
}
echo '</span>
                                            ';

        $gekkon->data['loop']['counter0']=$gekkon->data['loop']['counter']++;
        $gekkon->data['loop']['revcounter']=$gekkon->data['loop']['revcounter0']--;
        $gekkon->data['loop']['first']=0;
        $gekkon->data['loop']['last']=($gekkon->data['loop']['revcounter0']==0?1:0);
        }}
echo '
                                        </span>
                                                <span>Comments (';
echo $gekkon->data['article']['comments_count'];
echo ')</span>
                                            </td>
                                        </tr>
                                    ';
}}
echo '
                                </table>
                            </section>

                        </td>
                    </tr>
                </table>
            </main>

            <footer>
                <h5>&copy; ';
echo $gekkon->data['data']['shop_name'];
echo '</h5>
                <nav>
                    <ul>
                        ';
if(!empty($gekkon->data['data']['menu_list'])){
foreach($gekkon->data['data']['menu_list'] as $gekkon->data['menu_item']){
echo '
                            <li';
if($gekkon->data['menu_item']['current']){
echo ' class="current"';
}
echo '>
                                <a href="';
echo $gekkon->data['menu_item']['url'];
echo '">
                                    ';
if($gekkon->data['menu_item']['current']){
echo '
                                        <b>';
echo ucfirst($gekkon->data['menu_item']['name']);
echo '</b>
                                    ';
}else{
echo '
                                        ';
echo ucfirst($gekkon->data['menu_item']['name']);
echo '
                                    ';
}
echo '
                                </a>
                            </li>
                        ';
}}
echo '
                    </ul>
                </nav>

            </footer>

        </div>
    </body>
</html>
';
$_gkn_spaceless0 = ob_get_contents();ob_end_clean();
echo preg_replace('/>\s+</Uis', '><',preg_replace('/\s+/is', ' ', $_gkn_spaceless0));
}

function gekkon__tpl_main_inc_tpl(&$gekkon){
// Template file: /Users/denis/Work/Projects/te_bench/gekkon/tpl/main_inc.tpl
echo '<!doctype html>
';
ob_start();
echo '
<html>
    <head>
        <meta charset="utf-8">
        <title>';
echo ucwords($gekkon->data['data']['shop_name']);
echo '</title>
        <link rel="stylesheet" href="/css/page.css">
    </head>
    <body>
        <div id="layout">
            ';
$gekkon->display("parts/header.tpl");
echo '
            ';
$gekkon->display("parts/tizers.tpl");
echo '
            <hr/>
            <main>
                <table>
                    <tr>
                        <td id="left">
                            ';
$gekkon->display("parts/vendors.tpl");
echo '
                            <br/>
                            <br/>
                            ';
$gekkon->display("parts/online.tpl");
echo '
                        </td>
                        <td id="center">
                            ';
$gekkon->display("parts/good.tpl");
echo '
                            <br/>
                            ';
$gekkon->display("parts/comments.tpl");
echo '
                        </td>
                        <td id="right">
                            ';
$gekkon->display("parts/blog.tpl");
echo '
                            <br/>
                            ';
$gekkon->display("parts/news.tpl");
echo '
                        </td>
                    </tr>
                </table>
            </main>
            ';
$gekkon->display("parts/footer.tpl");
echo '
        </div>
    </body>
</html>
';
$_gkn_spaceless2 = ob_get_contents();ob_end_clean();
echo preg_replace('/>\s+</Uis', '><',preg_replace('/\s+/is', ' ', $_gkn_spaceless2));
}
