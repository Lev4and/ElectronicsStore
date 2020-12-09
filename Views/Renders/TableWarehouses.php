<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Адрес</th>
            <th class="table-block-header">Номер телефона</th>
        </tr>
        <?php foreach ($warehouses as $warehouse): ?>
            <tr id="<?php echo $warehouse["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedWarehouse" checked="checked" value="<?php echo $warehouse["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $warehouse["address"]; ?></td>
                <td class="table-block-value-text"><?php echo $warehouse["phone_number"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>