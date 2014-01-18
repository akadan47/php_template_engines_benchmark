<footer>
    <h5>&copy; {$data.shop_name}</h5>
    <nav>
        <ul>
            {foreach $data.menu_list as $menu_item}
                <li{if $menu_item.current} class="current"{/if}>
                    <a href="{$menu_item.url}">
                        {if $menu_item.current}
                            <b>{$menu_item.name.ucfirst()}</b>
                        {else}
                            {$menu_item.name.ucfirst()}
                        {/if}
                    </a>
                </li>
            {/foreach}
        </ul>
    </nav>
</footer>