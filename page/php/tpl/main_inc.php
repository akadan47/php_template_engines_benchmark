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
            <?php include("tpl/parts/header.php"); ?>
            <?php include("tpl/parts/tizers.php"); ?>

            <hr/>
            <main>
                <table>
                    <tr>
                        <td id="left">
                            <?php include("tpl/parts/vendors.php"); ?>
                            <br/>
                            <br/>
                            <?php include("tpl/parts/online.php"); ?>
                        </td>
                        <td id="center">
                            <?php include("tpl/parts/good.php"); ?>
                            <br/>
                            <?php include("tpl/parts/comments.php"); ?>
                        </td>
                        <td id="right">
                            <?php include("tpl/parts/blog.php"); ?>
                            <br/>
                            <?php include("tpl/parts/news.php"); ?>
                        </td>
                    </tr>
                </table>
            </main>
            <?php include("tpl/parts/footer.php"); ?>
        </div>
    </body>
</html>
<?php
$content = ob_get_contents();ob_end_clean();
echo preg_replace('/>\s+</Uis', '><',preg_replace('/\s+/is', ' ', $content));
?>