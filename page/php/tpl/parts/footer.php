<footer>
    <h5>&copy; <?php echo ucfirst($data["shop_name"]) ?></h5>
    <nav>
        <ul>
            <?php foreach ($data["menu_list"] as $menu_item) { ?>
                <li<?php if ($menu_item["current"]){echo" class=\"current\"";} ?>>
                    <a href="<?php echo $menu_item["url"]; ?>">
                        <?php if ($menu_item["current"]) { ?>
                            <b><?php echo ucfirst($menu_item["name"]); ?></b>
                        <?php } else { ?>
                            <?php echo ucfirst($menu_item["name"]); ?>
                        <?php } ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>

</footer>