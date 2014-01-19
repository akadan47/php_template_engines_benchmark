<section id="news">
    <h3>Recent News</h3>
    <table>
        <!-- set $counter = 0 -->
        <!--foreach from=$data.news_list item=$article-->
        <tr class="<!-- if $counter % 2 != 1 -->white<!-- else -->grey<!--/if-->">
            <td>
                <h4><a href="#news_{$article.id}.html">{$article.title}</a></h4>
                <span class="date">{$article.date->format('m/d/Y')}</span>
                <span class="lead">{$article.lead}</span>
                                        <span class="tags">
                                            Tags:
                                            <!-- set $tag_counter = 1 -->
                                            <!--foreach from=$article.tags item=$tag-->
                                                <span>{$tag}<!--if $tag_counter != $article.tags.count()-->, <!--else-->.<!--/if--></span>
                                                <!-- set $tag_counter = $tag_counter + 1 -->
                                            <!--/foreach-->
                                        </span>
                <span>Comments ({$article.comments_count})</span>
            </td>
        </tr>
        <!-- set $counter = $counter + 1 -->
        <!--/foreach-->
    </table>
</section>