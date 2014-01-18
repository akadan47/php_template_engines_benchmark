<section id="tizers">
    <table>
        <tr>
            {foreach from=$tizer_list item=tizer}
                <td>
                    <a href="{$tizer.url}">{$tizer.text}</a>
                </td>
            {/foreach}
        </tr>
    </table>
</section>
