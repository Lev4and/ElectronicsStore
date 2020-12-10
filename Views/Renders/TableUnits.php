<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($units as $unit): ?>
            <tr id="<?php echo $unit["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedUnit" checked="checked" value="<?php echo $unit["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $unit["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>