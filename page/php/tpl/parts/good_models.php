<section id="models">
    <b>Other models</b>
    <ul>
        <?php
        foreach ($good["model_list"] as $model) {
            echo "<li><a href=\"".$model["url"]."\">".$model["name"]."</a></li>";
        }
        ?>
    </ul>
</section>