<section id="comments">
    <h2>Comments ({$comments.count})</h2>
    <br/>
    <ul>
        {foreach from=$comments.list item=comment}
            <li>
                <b>{$comment.user}</b>, <span class="date">{$comment.date->format('m/d/Y')}</span>
                <p>
                    {$comment.text}
                </p>
            </li>
        {/foreach}
    </ul>
</section>