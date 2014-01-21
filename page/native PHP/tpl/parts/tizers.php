<section id="tizers">
    <table>
        <tr>
            <?php foreach ($data["tizer_list"] as $tizer) { ?>
                <td><a href="<?php echo $tizer["url"] ?>"><?php echo $tizer["text"] ?></a></td>
            <?php } ?>
        </tr>
    </table>
</section>