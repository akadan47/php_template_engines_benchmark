<section id="models">
    <b>Other models</b>
    <ul>
        {foreach $good.model_list as $model}
            <li><a href="{$model.url}">{$model.name}</a></li>
        {/foreach}
    </ul>
</section>