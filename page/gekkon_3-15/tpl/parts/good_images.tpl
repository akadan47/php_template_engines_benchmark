<section id="good_image">
    <div id="good_image_main">
        <img src="{$good.images.0}" alt=""/>
    </div>
    <div id="good_image_list">
        <!-- set $counter = 0 -->
        <!--foreach from=$good.images item=$image-->
        <!--if $counter != 0 -->
        <a href="#{$counter}"><img src="{$image}" alt=""/></a>
        <!--/if-->
        <!-- set $counter = $counter + 1 -->
        <!--/foreach-->
        <div style="clear: both"></div>
    </div>
</section>