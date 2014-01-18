<section id="online">
    <h4>Online users ({$data.online.count}):</h4>
    {foreach $data.online.users as $user; $loop}
        <span><a href="#profile/user.html?id={$user.0}">{$user.1}</a>{if !$loop.last}, {else}.{/if}</span>
    {/foreach}
</section>