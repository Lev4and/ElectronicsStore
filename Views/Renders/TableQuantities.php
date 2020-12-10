<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($quantities as $quantity): ?>
            <tr id="<?php echo $quantity["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedQuantity" checked="checked" value="<?php echo $quantity["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $quantity["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>