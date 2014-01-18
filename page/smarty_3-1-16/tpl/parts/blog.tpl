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