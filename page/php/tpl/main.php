<!doctype html>
<?php ob_start(); ?>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo ucwords($data["shop_name"]) ?></title>
        <link rel="stylesheet" href="/static/css/page.css">
    </head>
    <body>
        <div id="layout">

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

            <section id="tizers">
                <table>
                    <tr>
                        <?php foreach ($data["tizer_list"] as $tizer) { ?>
                                <td><a href="<?php echo $tizer["url"] ?>"><?php echo $tizer["text"] ?></a></td>
                        <?php } ?>
                    </tr>
                </table>
            </section>

            <hr/>

            <main>
                <table>
                    <tr>
                        <td id="left">

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

                            <br/>
                            <br/>

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

                        </td>
                        <td id="center">
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

                                        <section id="good_image">
                                            <div id="good_image_main">
                                                <img src="<?php echo $good["images"][0] ?>" alt=""/>
                                            </div>
                                            <div id="good_image_list">
                                                <?php
                                                    $counter = 0;
                                                    foreach ($good["images"] as $image) {
                                                        if ($counter != 0) {
                                                            echo "<a href=\"#".$counter."\"><img src=".$image." alt=\"\"/></a>";
                                                        }
                                                        $counter = $counter + 1;
                                                    }
                                                ?>
                                                <div style="clear: both"></div>
                                            </div>
                                        </section>

                                        <br/>
                                        <br/>

                                        <section id="models">
                                            <b>Other models</b>
                                            <ul>
                                                <?php
                                                    foreach ($good["model_list"] as $model) {
                                                        echo "<li><a href=\"".$model["url"]."\">".$model["name"]."</a></li>";
                                                    }
                                                ?>
                                            </ul>
                                        </section>

                                    </td>
                                    <td>

                                        <section id="price">
                                            <b>Price:</b> <?php echo "$".$good["price"]." (<s>$".$good["price_old"]."</s>)"; ?> <button>Buy</button>
                                        </section>

                                        <br/>
                                        <br/>

                                        <section id="details">
                                            <h3>Details</h3>
                                            <br/>
                                            <ul>
                                                <?php
                                                    foreach ($good["short_details"] as $detail) {
                                                        echo "<li>".$detail."</li>";
                                                    }
                                                ?>
                                            </ul>
                                        </section>

                                        <br/>

                                        <section id="tech_spec">
                                            <h3>Tech spec:</h3>
                                            <table>
                                                <?php foreach ($good["props"] as $property) { ?>
                                                    <tr>
                                                        <?php if ($property["type"] == 'category') { ?>
                                                            <td colspan="2" class="category"><b><?php echo ucfirst(strtolower($property["value"])) ?></b></td>
                                                        <?php } elseif ($property["type"] == 'bool') { ?>
                                                                <td><?php echo ucfirst($property["name"]) ?></td>
                                                                <td><?php if ($property["value"]){ echo "Yes"; } else { echo "No"; } ?></td>
                                                        <?php } elseif ($property["type"] == 'string') { ?>
                                                                <td><?php echo ucfirst($property["name"]) ?></td>
                                                                <td><?php echo $property["value"] ?></td>
                                                        <?php } elseif ($property["type"] == 'list') { ?>
                                                                <td><?php echo ucfirst($property["name"]) ?></td>
                                                                <td>
                                                                    <?php $counter = 1;
                                                                    foreach ($property["value"] as $value) {
                                                                        echo $value;
                                                                        if ($counter != count($property["value"])){
                                                                            echo ", ";
                                                                        } else {
                                                                            echo ".";
                                                                        }
                                                                        $counter = $counter + 1;
                                                                    } ?>
                                                                </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </section>

                                    </td>
                                </tr>
                            </table>

                            <br/>

                            <section id="comments">
                                <h2>Comments (<?php echo $data["comments"]["count"]; ?>)</h2>
                                <br/>
                                <ul>
                                    <?php
                                        foreach ($data["comments"]["list"] as $comment) {
                                            echo "<li><b>".$comment["user"]."</b>, <span class=\"date\">".$comment["date"]->format('m/d/Y')."</span><p>".$comment["text"]."</p></li>";
                                        }
                                    ?>
                                </ul>
                            </section>

                        </td>
                        <td id="right">

                            <section id="blog">
                                <h3>Blog</h3>
                                <br/>
                                <ul>
                                    <?php
                                        foreach ($data["blog_posts"] as $post) {
                                            echo "<li>".$post["date"]->format('m/d/Y')." <br/> <a href=\"#blog_".$post["id"]["html"]."\">".$post["title"]."</a></li><br/>";
                                        }
                                    ?>
                                </ul>
                            </section>

                            <br/>

                            <section id="news">
                                <h3>Recent News</h3>
                                <table>
                                    <?php $counter = 0; ?>
                                    <?php foreach ($data["news_list"] as $article) { ?>
                                        <tr class="<?php if (($counter % 2) != 1){
                                            echo "white"; } else {
                                            echo "grey";
                                        } ?>">
                                            <td>
                                                <h4><a href="#news_<?php echo $article["id"]; ?>.html"><?php echo $article["title"]; ?></a></h4>
                                                <span class="date"><?php echo $article["date"]->format('m/d/Y'); ?></span>
                                                <span class="lead"><?php echo $article["lead"]; ?></span>
                                                <span class="tags">
                                                    Tags:
                                                    <?php $tag_counter = 1; ?>
                                                    <?php foreach ($article["tags"] as $tag) {
                                                        echo "<span>".$tag;
                                                        if ($tag_counter != count($article["tags"])) {echo ", ";} else {echo ".";};
                                                        echo "</span>";
                                                        $tag_counter = $tag_counter + 1;
                                                    } ?>
                                                </span>
                                                <span>Comments (<?php echo $article["comments_count"]; ?>)</span>
                                            </td>
                                        </tr>
                                        <?php $counter = $counter + 1; ?>
                                    <?php } ?>
                                </table>
                            </section>

                        </td>
                    </tr>
                </table>
            </main>

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

        </div>
    </body>
</html>
<?php
$content = ob_get_contents();ob_end_clean();
echo preg_replace('/>\s+</Uis', '><',preg_replace('/\s+/is', ' ', $content));
?>