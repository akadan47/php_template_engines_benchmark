<section id="news">
    <h3>Recent News</h3>
    <table>
        <?php $counter = 0; ?>
        <?php foreach ($data["news_list"] as $article) { ?>
            <tr class="<?php if (($counter % 2) != 1){
                echo "white"; } else {
                echo "grey";
            } ?>">
                <td>
                    <h4><a href="#news_<?php echo $article["id"]; ?>.html"><?php echo $article["title"]; ?></a></h4>
                    <span class="date"><?php echo $article["date"]->format('m/d/Y'); ?></span>
                    <span class="lead"><?php echo $article["lead"]; ?></span>
                                                <span class="tags">
                                                    Tags:
                                                    <?php $tag_counter = 1; ?>
                                                    <?php foreach ($article["tags"] as $tag) {
                                                        echo "<span>".$tag;
                                                        if ($tag_counter != count($article["tags"])) {echo ", ";} else {echo ".";};
                                                        echo "</span>";
                                                        $tag_counter = $tag_counter + 1;
                                                    } ?>
                                                </span>
                    <span>Comments (<?php echo $article["comments_count"]; ?>)</span>
                </td>
            </tr>
            <?php $counter = $counter + 1; ?>
        <?php } ?>
    </table>
</section>