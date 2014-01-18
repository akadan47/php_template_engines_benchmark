<section id="tech_spec">
    <h3>Tech spec:</h3>
    <table>
        {foreach $good.props as $property}
            {include "parts/good_tech_spec_prop.tpl"}
        {/foreach}
    </table>
</section>