<section id="news">
    <h3>Recent News</h3>
    <table>
        {foreach $data.news_list as $article}
            <tr class="{cycle "white", "grey"}">
                <td>
                    <h4><a href="#news_{$article.id}.html">{$article.title}</a></h4>
                    <span class="date">{$article.date->format('m/d/Y')}</span>
                    <span class="lead">{$article.lead}</span>
                    <span class="tags">Tags:
                        {foreach $article.tags as $tag; $loop}
                            <span>{$tag}{if !$loop.last}, {else}.{/if}</span>
                        {/foreach}
                    </span>
                    <span>Comments ({$article.comments_count})</span>
                </td>
            </tr>
        {/foreach}
    </table>
</section>