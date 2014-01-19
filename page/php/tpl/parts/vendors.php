<section id="vendors">
    <h4>Vendors:</h4>
    <ul>
        <?php
        foreach ($data["vendor_list"] as $vendor) {
            echo "<li";
            if($vendor["id"] == $data["good"]["vendor"]["id"])
                echo " class=\"current\"";
            echo "><a href=\"#vendor_".$vendor["id"].".html\">".ucfirst($vendor["name"])."</a></li>";
        }
        ?>
    </ul>
</section>