<tr>
    <!-- switch $property.type -->
    <!-- case 'category'-->
    <td colspan="2" class="category"><b>{$property.value.strtolower().ucfirst()}</b></td>
    <!-- case 'bool'-->
    <td>{$property.name.ucfirst()}</td>
    <td><!--if $property.value-->Yes<!--else-->No<!--/if--></td>
    <!-- case 'string'-->
    <td>{$property.name.ucfirst()}</td>
    <td>{$property.value}</td>
    <!-- case 'list'-->
    <td>{$property.name.ucfirst()}</td>
    <td>
        <!-- set $counter = 1 -->
        <!--foreach from=$property.value item=$value-->
        {$value}<!--if $counter != $property.value.count() -->,<!--else-->.<!--/if-->
        <!-- set $counter = $counter + 1 -->
        <!--/foreach-->
    </td>
    <!--/switch-->
</tr>
