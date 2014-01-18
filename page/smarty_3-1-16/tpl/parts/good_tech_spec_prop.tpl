<tr>
    {if $property.type == 'category'}
        <td colspan="2" class="category"><b>{$property.value|lower|ucfirst}</b></td>
    {elseif $property.type == 'bool'}
        <td>{$property.name|ucfirst}</td>
        <td>{if $property.value}Yes{else}No{/if}</td>
    {elseif $property.type == 'string'}
        <td>{$property.name|ucfirst}</td>
        <td>{$property.value}</td>
    {elseif $property.type == 'list'}
        <td>{$property.name|ucfirst}</td>
        <td>
            {foreach from=$property.value item=value name=loop}
                {$value}{if !$smarty.foreach.loop.last}, {else}.{/if}
            {/foreach}
        </td>
    {/if}
</tr>
