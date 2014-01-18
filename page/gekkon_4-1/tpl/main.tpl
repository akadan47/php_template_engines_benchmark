<!doctype html>
{spaceless}
<html>
    <head>
        <meta charset="utf-8">
        <title>{$data.shop_name.ucwords()}</title>
        <link rel="stylesheet" href="/static/css/page.css">
    </head>
    <body>
        <div id="layout">

            <header>
                <h2>{$data.shop_name.ucwords()}</h2>
                <br/>
                <nav>
                    <ul>
                        {foreach $data.menu_list as $menu_item}
                            <li{if $menu_item.current} class="current"{/if}>
                                <a href="{$menu_item.url}">
                                    {if $menu_item.current}
                                        <b>{$menu_item.name.ucfirst()}</b>
                                    {else}
                                        {$menu_item.name.ucfirst()}
                                    {/if}
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                </nav>
            </header>

            <section id="tizers">
                <table>
                    <tr>
                        {foreach $data.tizer_list as $tizer}
                            <td>
                                <a href="{$tizer.url}">{$tizer.text}</a>
                            </td>
                        {/foreach}
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
                                    {foreach $data.vendor_list as $vendor}
                                        <li{if $vendor.id == $data.good.vendor.id} class="current"{/if}><a href="#vendor_{$vendor.id}.html">{$vendor.name}</a></li>
                                    {/foreach}
                                </ul>
                            </section>

                            <br/>
                            <br/>

                            <section id="online">
                                <h4>Online users ({$data.online.count}):</h4>
                                {foreach $data.online.users as $user; $loop}
                                    <span><a href="#profile/user.html?id={$user.0}">{$user.1}</a>{if !$loop.last}, {else}.{/if}</span>
                                {/foreach}
                            </section>

                        </td>
                        <td id="center">

                            {set $good = $data.good}
                            {set $title = $good.vendor.name . " " . $good.name}
                            <h1>{$title} {if $good.model}({$good.model}){/if}</h1>

                            <span>
                                <b>Color:</b> {$good.color}, <b>Warranty:</b> {$good.warranty}, <b>Country:</b> {$good.country}
                            </span>

                            <br/>
                            <br/>

                            <table id="good_layout">
                                <tr>
                                    <td>

                                        <section id="good_image">
                                            <div id="good_image_main">
                                                <img src="{$good.images.0}" alt=""/>
                                            </div>
                                            <div id="good_image_list">
                                                {foreach $good.images as $image; $loop}
                                                    {if !$loop.first }
                                                        <a href="#{$loop.counter}"><img src="{$image}" alt=""/></a>
                                                    {/if}
                                                {/foreach}
                                                <div style="clear: both"></div>
                                            </div>
                                        </section>

                                        <br/>
                                        <br/>

                                        <section id="models">
                                            <b>Other models</b>
                                            <ul>
                                                {foreach $good.model_list as $model}
                                                    <li><a href="{$model.url}">{$model.name}</a></li>
                                                {/foreach}
                                            </ul>
                                        </section>

                                    </td>
                                    <td>

                                        <section id="price">
                                            <b>Price:</b> ${$good.price} (<s>${$good.price_old}</s>) <button>Buy</button>
                                        </section>

                                        <br/>
                                        <br/>

                                        <section id="details">
                                            <h3>Details</h3>
                                            <br/>
                                            <ul>
                                                {foreach $good.short_details as $detail}
                                                    <li>{$detail}</li>
                                                {/foreach}
                                            </ul>
                                        </section>

                                        <br/>

                                        <section id="tech_spec">
                                            <h3>Tech spec:</h3>
                                            <table>
                                                {foreach $good.props as $property}
                                                    <tr>
                                                        {if $property.type == 'category'}
                                                            <td colspan="2" class="category"><b>{$property.value.strtolower().ucfirst()}</b></td>
                                                        {elseif $property.type == 'bool'}
                                                            <td>{$property.name.ucfirst()}</td>
                                                            <td>{if $property.value}Yes{else}No{/if}</td>
                                                        {elseif $property.type == 'string'}
                                                            <td>{$property.name.ucfirst()}</td>
                                                            <td>{$property.value}</td>
                                                        {elseif $property.type == 'list'}
                                                            <td>{$property.name.ucfirst()}</td>
                                                            <td>
                                                                {foreach $property.value as $value; $loop}
                                                                    {$value}{if !$loop.last},{else}.{/if}
                                                                {/foreach}
                                                            </td>
                                                        {/if}
                                                    </tr>
                                                {/foreach}
                                            </table>
                                        </section>

                                    </td>
                                </tr>
                            </table>

                            <br/>

                            <section id="comments">
                                <h2>Comments ({$data.comments.count})</h2>
                                <br/>
                                <ul>
                                    {foreach $data.comments.list as $comment}
                                        <li>
                                            <b>{$comment.user}</b>, <span class="date">{$comment.date->format('m/d/Y')}</span>
                                            <p>
                                                {$comment.text}
                                            </p>
                                        </li>
                                    {/foreach}
                                </ul>
                            </section>

                        </td>
                        <td id="right">

                            <section id="blog">
                                <h3>Blog</h3>
                                <br/>
                                <ul>
                                    {foreach $data.blog_posts as $post}
                                        <li>{$post.date->format('m/d/Y')} <br/> <a href="#blog_{$post.id}.html">{$post.title}</a></li>
                                        <br/>
                                    {/foreach}
                                </ul>
                            </section>

                            <br/>

                            <section id="news">
                                <h3>Recent News</h3>
                                <table>
                                    {foreach $data.news_list as $article}
                                        <tr class="{cycle "white", "grey"}">
                                            <td>
                                                <h4><a href="#news_{$article.id}.html">{$article.title}</a></h4>
                                                <span class="date">{$article.date->format('m/d/Y')}</span>
                                                <span class="lead">{$article.lead}</span>
                                        <span class="tags">
                                            Tags:
                                            {foreach $article.tags as $tag; $loop}
                                                <span>{$tag}{if !$loop.last}, {else}.{/if}</span>
                                            {/foreach}
                                        </span>
                                                <span>Comments ({$article.comments_count})</span>
                                            </td>
                                        </tr>
                                    {/foreach}
                                </table>
                            </section>

                        </td>
                    </tr>
                </table>
            </main>

            <footer>
                <h5>&copy; {$data.shop_name}</h5>
                <nav>
                    <ul>
                        {foreach $data.menu_list as $menu_item}
                            <li{if $menu_item.current} class="current"{/if}>
                                <a href="{$menu_item.url}">
                                    {if $menu_item.current}
                                        <b>{$menu_item.name.ucfirst()}</b>
                                    {else}
                                        {$menu_item.name.ucfirst()}
                                    {/if}
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                </nav>

            </footer>

        </div>
    </body>
</html>
{/spaceless}