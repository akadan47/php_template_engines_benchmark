<section id="tech_spec">
    <h3>Tech spec:</h3>
    <table>
        {foreach from=$good.props item=property}
            {include file="parts/good_tech_spec_prop.tpl"}
        {/foreach}
    </table>
</section>