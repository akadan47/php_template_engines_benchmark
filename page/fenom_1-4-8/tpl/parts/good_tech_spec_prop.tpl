<tr>
    {if $property.type == 'category'}
        <td colspan="2" class="category"><b>{ucfirst(strtolower($property.value))}</b></td>
    {elseif $property.type == 'bool'}
        <td>{ucfirst($property.name)}</td>
        <td>{if $property.value}Yes{else}No{/if}</td>
    {elseif $property.type == 'string'}
        <td>{ucfirst($property.name)}</td>
        <td>{$property.value}</td>
    {elseif $property.type == 'list'}
        <td>{ucfirst($property.name)}</td>
        <td>
            {foreach $property.value as $value last=$last}
                {$value}{if !$last},{else}.{/if}
            {/foreach}
        </td>
    {/if}
</tr>
