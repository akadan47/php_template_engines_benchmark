<tr>
    {if $property.type == 'category'}
        <td colspan="2" class="category"><b>{$property.value.strtolower().ucfirst()}</b></td>
    {elseif $property.type == 'bool'}
        <td>{$property.name.ucfirst()}</td>
        <td>{if $property.value}Yes{else}No{/if}</td>
    {elseif $property.type == 'string'}
        <td>{$property.name.ucfirst()}</td>
        <td>{$property.value}</td>
    {elseif $property.type == 'list'}
        <td>{$property.name.ucfirst()}</td>
        <td>
            {foreach $property.value as $value; $loop}
                {$value}{if !$loop.last},{else}.{/if}
            {/foreach}
        </td>
    {/if}
</tr>
