<section id="comments">
    <h2>Comments (<?php echo $data["comments"]["count"]; ?>)</h2>
    <br/>
    <ul>
        <?php
        foreach ($data["comments"]["list"] as $comment) {
            echo "<li><b>".$comment["user"]."</b>, <span class=\"date\">".$comment["date"]->format('m/d/Y')."</span><p>".$comment["text"]."</p></li>";
        }
        ?>
    </ul>
</section>