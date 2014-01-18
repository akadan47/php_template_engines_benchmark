<section id="details">
    <h3>Details</h3>
    <br/>
    <ul>
        {foreach from=$good.short_details item=detail}
            <li>{$detail}</li>
        {/foreach}
    </ul>
</section>