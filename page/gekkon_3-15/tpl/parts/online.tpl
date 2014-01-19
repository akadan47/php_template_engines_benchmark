<section id="online">
    <h4>Online users ({$data.online.count}):</h4>
    <!-- set $counter = 1 -->
    <!--foreach from=$data.online.users item=$user-->
    <span><a href="#profile/user.html?id={$user.0}">{$user.1}</a><!--if $counter != $data.online.count-->, <!--else-->.<!--/if--></span>
    <!-- set $counter = $counter + 1 -->
    <!--/foreach-->
</section>