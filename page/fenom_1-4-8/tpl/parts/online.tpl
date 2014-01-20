<section id="online">
    <h4>Online users ({$online.count}):</h4>
    {foreach $online.users as $user last=$last}
        <span><a href="#profile/user.html?id={$user.0}">{$user.1}</a>{if !$last}, {else}.{/if}</span>
    {/foreach}
</section>