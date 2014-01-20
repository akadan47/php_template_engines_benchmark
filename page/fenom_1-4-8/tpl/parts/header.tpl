<header>
    <h2>{ucwords($shop_name)}</h2>
    <br/>
    <nav>
        <ul>
            {foreach $menu_list as $menu_item}
                <li{if $menu_item.current} class="current"{/if}>
                    <a href="{$menu_item.url}">
                        {if $menu_item.current}
                            <b>{ucfirst($menu_item.name)}</b>
                        {else}
                            {ucfirst($menu_item.name)}
                        {/if}
                    </a>
                </li>
            {/foreach}
        </ul>
    </nav>
</header>