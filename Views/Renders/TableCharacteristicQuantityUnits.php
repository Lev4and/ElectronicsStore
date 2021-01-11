<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Характеристика</th>
            <th class="table-block-header">Величина и единица измерения</th>
        </tr>
        <?php foreach ($characteristicQuantityUnits as $key => $characteristicQuantityUnit): ?>
            <?php if($key >= ($_SESSION["pageNumber"] - 1) * 25 && $key <= $_SESSION["pageNumber"] * 25 - 1): ?>
                <tr id="<?php echo $characteristicQuantityUnit["id"]; ?>" class="table-block-values">
                    <td class="table-block-value-input-radio"><input type="radio" name="selectedCharacteristicQuantityUnit" checked="checked" value="<?php echo $characteristicQuantityUnit["id"]; ?>"></td>
                    <td class="table-block-value-text"><?php echo $characteristicQuantityUnit["characteristic_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo "{$characteristicQuantityUnit["quantity_name"]} - {$characteristicQuantityUnit["unit_name"]} ({$characteristicQuantityUnit["unit_designation"]})"; ?></td>
                </tr>
            <?php endif; ?>
        <? endforeach; ?>
    </table>
</div>