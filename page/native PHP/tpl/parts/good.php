<?php
$good = $data["good"];
$title = $good["vendor"]["name"] . " " . $good["name"];
echo "<h1>".$title." ";
if ($good["model"]) {
    echo "(".$good["model"].")";
}
echo "</h1>";
echo "<span><b>Color: </b>".$good["color"].", <b>Warranty: </b> ".$good["warranty"].", <b>Country: </b> ".$good["country"]."</span>";
?>

<br/>
<br/>

<table id="good_layout">
    <tr>
        <td>
            <?php include("good_images.php"); ?>
            <br/>
            <br/>
            <?php include("good_models.php"); ?>
        </td>
        <td>
            <section id="price">
                <b>Price:</b> <?php echo "$".$good["price"]." (<s>$".$good["price_old"]."</s>)"; ?> <button>Buy</button>
            </section>
            <br/>
            <br/>
            <?php include("good_details.php"); ?>
            <br/>
            <?php include("good_tech_spec.php"); ?>
        </td>
    </tr>
</table>