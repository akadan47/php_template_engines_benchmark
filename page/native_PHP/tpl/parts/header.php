<header>
    <h2><?php echo ucwords($data["shop_name"]) ?></h2>
    <br/>
    <nav>
        <ul>
            <?php
            foreach ($data["menu_list"] as $menu_item) {
                echo "<li";
                if($menu_item["current"]) {
                    echo " class=\"current\"";
                }
                echo "><a href=\"".$menu_item["url"]."\">";
                if ($menu_item["current"]) {
                    echo "<b>".ucfirst($menu_item["name"])."</b>";
                } else {
                    echo ucfirst($menu_item["name"]);
                }
                echo "</a></li>";
            }
            ?>
        </ul>
    </nav>
</header>