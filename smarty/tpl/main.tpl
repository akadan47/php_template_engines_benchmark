<!doctype html>
{strip}
<html>
<head>
    <meta charset="utf-8">
    <title>{$shop_name|capitalize}</title>
    <link rel="stylesheet" href="/_files/css/page.css">
</head>
<body>
<div id="layout">

<header>
    <h2>{$shop_name|capitalize}</h2>
    <br/>
    <nav>
        <ul>
            {foreach from=$menu_list item=menu_item}
                <li{if $menu_item.current} class="current"{/if}>
                    <a href="{$menu_item.url}">
                        {if $menu_item.current}
                            <b>{$menu_item.name|ucfirst}</b>
                        {else}
                            {$menu_item.name|ucfirst}
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
            {foreach from=$tizer_list item=tizer}
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
                        {foreach from=$vendor_list item=vendor}
                            <li{if $vendor.id == $good.vendor.id} class="current"{/if}><a href="#vendor_{$vendor.id}.html">{$vendor.name}</a></li>
                        {/foreach}
                    </ul>
                </section>

                <br/>
                <br/>

                <section id="online">
                    <h4>Online users ({$online.count}):</h4>
                    {foreach from=$online.users item=user name=loop}
                        <span><a href="#profile/user.html?id={$user.0}">{$user.1}</a>{if !$smarty.foreach.loop.last}, {else}.{/if}</span>
                    {/foreach}
                </section>

            </td>
            <td id="center">

                {assign var=good value=$good}
                {assign var=title value="`$good.vendor.name` `$good.name`"}
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
                                    <img src="{$good.images[0]}" alt=""/>
                                </div>
                                <div id="good_image_list">
                                    {foreach from=$good.images item=image name=loop}
                                        {if !$smarty.foreach.loop.first }
                                            <a href="#{$smarty.foreach.loop.iteration}"><img src="{$image}" alt=""/></a>
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
                                    {foreach from=$good.model_list item=model}
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
                                    {foreach from=$good.short_details item=detail}
                                        <li>{$detail}</li>
                                    {/foreach}
                                </ul>
                            </section>

                            <br/>

                            <section id="tech_spec">
                                <h3>Tech spec:</h3>
                                <table>
                                    {foreach from=$good.props item=property}
                                        <tr>
                                            {if $property.type == 'category'}
                                                <td colspan="2" class="category"><b>{$property.value|lower|ucfirst}</b></td>
                                            {elseif $property.type == 'bool'}
                                                <td>{$property.name|ucfirst}</td>
                                                <td>{if $property.value}Yes{else}No{/if}</td>
                                            {elseif $property.type == 'string'}
                                                <td>{$property.name|ucfirst}</td>
                                                <td>{$property.value}</td>
                                            {elseif $property.type == 'list'}
                                                <td>{$property.name|ucfirst}</td>
                                                <td>
                                                    {foreach from=$property.value item=value name=loop}
                                                        {$value}{if !$smarty.foreach.loop.last}, {else}.{/if}
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
                    <h2>Comments ({$comments.count})</h2>
                    <br/>
                    <ul>
                        {foreach from=$comments.list item=comment}
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
                        {foreach from=$blog_posts item=post}
                            <li>{$post.date->format('m/d/Y')} <br/> <a href="#blog_{$post.id}.html">{$post.title}</a></li>
                            <br/>
                        {/foreach}
                    </ul>
                </section>

                <br/>

                <section id="news">
                    <h3>Recent News</h3>
                    <table>
                        {foreach from=$news_list item=article}
                            <tr class="{cycle values="white, grey"}">
                                <td>
                                    <h4><a href="#news_{$article.id}.html">{$article.title}</a></h4>
                                    <span class="date">{$article.date->format('m/d/Y')}</span>
                                    <span class="lead">{$article.lead}</span>
                                        <span class="tags">
                                            Tags: 
                                            {foreach from=$article.tags item=tag name=loop}
                                                <span>{$tag}{if !$smarty.foreach.loop.last}, {else}.{/if}</span>
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
    <h5>&copy; {$shop_name}</h5>
    <nav>
        <ul>
            {foreach from=$menu_list item=menu_item}
                <li{if $menu_item.current} class="current"{/if}>
                    <a href="{$menu_item.url}">
                        {if $menu_item.current}
                            <b>{$menu_item.name|ucfirst}</b>
                        {else}
                            {$menu_item.name|ucfirst}
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
{/strip}