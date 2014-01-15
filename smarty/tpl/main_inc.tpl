<!doctype html>
{strip}
<html>
<head>
    <meta charset="utf-8">
    <title>{$shop_name|capitalize}</title>
    <link rel="stylesheet" href="/css/page.css">
</head>
<body>
<div id="layout">
    {include file="parts/header.tpl"}
    {include file="parts/tizers.tpl"}
    <hr/>
    <main>
        <table>
            <tr>
                <td id="left">
                    {include file="parts/vendors.tpl"}
                    <br/>
                    <br/>
                    {include file="parts/online.tpl"}
                </td>
                <td id="center">
                    {include file="parts/good.tpl"}
                    <br/>
                    {include file="parts/comments.tpl"}
                </td>
                <td id="right">
                    {include file="parts/blog.tpl"}
                    <br/>
                    {include file="parts/news.tpl"}
                </td>
            </tr>
        </table>
    </main>
    {include file="parts/footer.tpl"}
</div>
</body>
</html>
{/strip}