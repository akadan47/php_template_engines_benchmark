<section id="details">
    <h3>Details</h3>
    <br/>
    <ul>
        {foreach $good.short_details as $detail}
            <li>{$detail}</li>
        {/foreach}
    </ul>
</section>