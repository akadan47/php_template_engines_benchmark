<section id="vendors">
    <h4>Vendors:</h4>
    <ul>
        {foreach $vendor_list as $vendor}
            <li{if $vendor.id == $good.vendor.id} class="current"{/if}><a href="#vendor_{$vendor.id}.html">{$vendor.name}</a></li>
        {/foreach}
    </ul>
</section>