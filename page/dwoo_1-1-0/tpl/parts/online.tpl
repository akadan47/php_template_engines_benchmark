<section id="online">
    <h4>Online users ({$online.count}):</h4>
    {foreach from=$online.users item=user name=loop}
        <span><a href="#profile/user.html?id={$user.0}">{$user.1}</a>{if !$dwoo.foreach.loop.last}, {else}.{/if}</span>
    {/foreach}
</section>