<!doctype html>
<!-- nowarp -->
<html>
    <head>
        <meta charset="utf-8">
        <title>{$data.shop_name.ucwords()}</title>
        <link rel="stylesheet" href="/static/css/page.css">
    </head>
    <body>
        <div id="layout">
            <!-- include "parts/header.tpl" -->
            <!-- include "parts/tizers.tpl" -->
            <hr/>
            <main>
                <table>
                    <tr>
                        <td id="left">
                            <!-- include "parts/vendors.tpl" -->
                            <br/>
                            <br/>
                            <!-- include "parts/online.tpl" -->
                        </td>
                        <td id="center">
                            <!-- include "parts/good.tpl" -->
                            <br/>
                            <!-- include "parts/comments.tpl" -->
                        </td>
                        <td id="right">
                            <!-- include "parts/blog.tpl" -->
                            <br/>
                            <!-- include "parts/news.tpl" -->
                        </td>
                    </tr>
                </table>
            </main>
            <!-- include "parts/footer.tpl" -->
        </div>
    </body>
</html>
<!-- /nowarp -->