<section id="good_image">
    <div id="good_image_main">
        <img src="<?php echo $good["images"][0] ?>" alt=""/>
    </div>
    <div id="good_image_list">
        <?php
        $counter = 0;
        foreach ($good["images"] as $image) {
            if ($counter != 0) {
                echo "<a href=\"#".$counter."\"><img src=".$image." alt=\"\"/></a>";
            }
            $counter = $counter + 1;
        }
        ?>
        <div style="clear: both"></div>
    </div>
</section>