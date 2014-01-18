<header>
    <h2>{$shop_name|capitalize}</h2>
    <br/>
    <nav>
        <ul>
            {foreach from=$menu_list item=menu_item}
                <li{if $menu_item.current} class="current"{/if}>
                    <a href="{$menu_item.url}">
                        {if $menu_item.current}
                            <b>{$menu_item.name|ucfirst}</b>
                        {else}
                            {$menu_item.name|ucfirst}
                        {/if}
                    </a>
                </li>
            {/foreach}
        </ul>
    </nav>
</header>