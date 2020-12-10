<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Характеристика</th>
            <th class="table-block-header">Величина</th>
            <th class="table-block-header">Единица измерения</th>
            <th class="table-block-header">Значение</th>
        </tr>
        <?php foreach ($characteristicQuantityUnitValues as $characteristicQuantityUnitValue): ?>
            <tr id="<?php echo $characteristicQuantityUnitValue["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedCharacteristicQuantityUnitValue" checked="checked" value="<?php echo $characteristicQuantityUnitValue["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $characteristicQuantityUnitValue["characteristic_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $characteristicQuantityUnitValue["quantity_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $characteristicQuantityUnitValue["unit_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $characteristicQuantityUnitValue["value"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>