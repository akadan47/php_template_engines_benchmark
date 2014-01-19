<section id="blog">
    <h3>Blog</h3>
    <br/>
    <ul>
        <?php
        foreach ($data["blog_posts"] as $post) {
            echo "<li>".$post["date"]->format('m/d/Y')." <br/> <a href=\"#blog_".$post["id"]["html"]."\">".$post["title"]."</a></li><br/>";
        }
        ?>
    </ul>
</section>