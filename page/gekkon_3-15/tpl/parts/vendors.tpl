<section id="vendors">
    <h4>Vendors:</h4>
    <ul>
        <!--foreach from=$data.vendor_list item=$vendor-->
        <li<!--if $vendor.id == $data.good.vendor.id--> class="current"<!--/if-->><a href="#vendor_{$vendor.id}.html">{$vendor.name}</a></li>
        <!--/foreach-->
    </ul>
</section>