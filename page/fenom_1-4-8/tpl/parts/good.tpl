{var $good = $good}
{var $title} {$good.vendor.name} {$good.name}{/var}
<h1>{$title} {if $good.model}({$good.model}){/if}</h1>

<span><b>Color:</b> {$good.color}, <b>Warranty:</b> {$good.warranty}, <b>Country:</b> {$good.country}</span>

<br/>
<br/>

<table id="good_layout">
    <tr>
        <td>
            {include "parts/good_images.tpl"}
            <br/>
            <br/>
            {include "parts/good_models.tpl"}
        </td>
        <td>
            <section id="price">
                <b>Price:</b> ${$good.price} (<s>${$good.price_old}</s>) <button>Buy</button>
            </section>
            <br/>
            <br/>
            {include "parts/good_details.tpl"}
            <br/>
            {include "parts/good_tech_spec.tpl"}
        </td>
    </tr>
</table>