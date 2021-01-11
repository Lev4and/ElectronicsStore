<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Величина</th>
            <th class="table-block-header">Единица измерения</th>
            <th class="table-block-header">Обозначение единицы измерения</th>
        </tr>
        <?php foreach ($quantityUnits as $key => $quantityUnit): ?>
            <?php if($key >= ($_SESSION["pageNumber"] - 1) * 25 && $key <= $_SESSION["pageNumber"] * 25 - 1): ?>
                <tr id="<?php echo $quantityUnit["id"]; ?>" class="table-block-values">
                    <td class="table-block-value-input-radio"><input type="radio" name="selectedQuantityUnit" checked="checked" value="<?php echo $quantityUnit["id"]; ?>"></td>
                    <td class="table-block-value-text"><?php echo $quantityUnit["quantity_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $quantityUnit["unit_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $quantityUnit["unit_designation"]; ?></td>
                </tr>
            <?php endif; ?>
        <? endforeach; ?>
    </table>
</div>