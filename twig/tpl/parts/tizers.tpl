<section id="tizers">
    <table>
        <tr>
            {foreach $data.tizer_list as $tizer}
                <td>
                    <a href="{$tizer.url}">{$tizer.text}</a>
                </td>
            {/foreach}
        </tr>
    </table>
</section>
