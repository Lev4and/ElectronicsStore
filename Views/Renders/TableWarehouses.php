<div class="warehouses">
    <table class="table-warehouses" border="1">
        <tr class="table-warehouses-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="warehouse-address" class="warehouse-address">Адрес</th>
            <th id="warehouse-phone-number" class="warehouse-phone-number">Номер телефона</th>
        </tr>
        <?php foreach ($warehouses as $warehouse): ?>
            <tr id="<?php echo $warehouse["id"]; ?>" class="table-warehouses-row-values">
                <td id="select" class="select"><input type="radio" name="selectedWarehouse" checked="checked" value="<?php echo $warehouse["id"]; ?>"></td>
                <td id="warehouse-address" class="warehouse-address"><?php echo $warehouse["address"]; ?></td>
                <td id="warehouse-phone-number" class="warehouse-phone-number"><?php echo $warehouse["phone_number"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>