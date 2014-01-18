<section id="comments">
    <h2>Comments ({$data.comments.count})</h2>
    <br/>
    <ul>
        {foreach $data.comments.list as $comment}
            <li>
                <b>{$comment.user}</b>, <span class="date">{$comment.date->format('m/d/Y')}</span>
                <p>
                    {$comment.text}
                </p>
            </li>
        {/foreach}
    </ul>
</section>