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