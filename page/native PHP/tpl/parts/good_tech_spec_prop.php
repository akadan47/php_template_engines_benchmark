<tr>
    <?php if ($property["type"] == 'category') { ?>
        <td colspan="2" class="category"><b><?php echo ucfirst(strtolower($property["value"])) ?></b></td>
    <?php } elseif ($property["type"] == 'bool') { ?>
        <td><?php echo ucfirst($property["name"]) ?></td>
        <td><?php if ($property["value"]){ echo "Yes"; } else { echo "No"; } ?></td>
    <?php } elseif ($property["type"] == 'string') { ?>
        <td><?php echo ucfirst($property["name"]) ?></td>
        <td><?php echo $property["value"] ?></td>
    <?php } elseif ($property["type"] == 'list') { ?>
        <td><?php echo ucfirst($property["name"]) ?></td>
        <td>
            <?php $counter = 1;
            foreach ($property["value"] as $value) {
                echo $value;
                if ($counter != count($property["value"])){
                    echo ", ";
                } else {
                    echo ".";
                }
                $counter = $counter + 1;
            } ?>
        </td>
    <?php } ?>
</tr>
