<section id="good_image">
    <div id="good_image_main">
        <img src="{$good.images.0}" alt=""/>
    </div>
    <div id="good_image_list">
        {foreach $good.images as $image first=$first index=$index}
            {if !$first }
                <a href="#{$index}"><img src="{$image}" alt=""/></a>
            {/if}
        {/foreach}
        <div style="clear: both"></div>
    </div>
</section>