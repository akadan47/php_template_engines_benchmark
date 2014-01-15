<header>
    <h2>{$data.shop_name.ucwords()}</h2>
    <br/>
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
</header>