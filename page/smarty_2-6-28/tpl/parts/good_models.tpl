<section id="models">
    <b>Other models</b>
    <ul>
        {foreach from=$good.model_list item=model}
            <li><a href="{$model.url}">{$model.name}</a></li>
        {/foreach}
    </ul>
</section>