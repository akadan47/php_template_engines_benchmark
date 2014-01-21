<section id="online">
    <h4>Online users (<?php echo $data["online"]["count"]; ?>):</h4>
    <?php
    $counter = 1;
    foreach ($data["online"]["users"] as $user) {
        echo "<span><a href=\"#profile/user.html?id=".$user[0]."\">".$user[1]."</a>";
        if ($counter != $data["online"]["count"]) {
            echo ", ";
        } else {
            echo ".";
        }
        echo "</span>";
        $counter = $counter + 1;
    }
    ?>

</section>