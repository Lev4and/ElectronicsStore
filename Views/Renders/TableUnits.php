<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Название</th>
            <th class="table-block-header">Обозначение</th>
        </tr>
        <?php foreach ($units as $key => $unit): ?>
            <?php if($key >= ($_SESSION["pageNumber"] - 1) * 25 && $key <= $_SESSION["pageNumber"] * 25 - 1): ?>
                <tr id="<?php echo $unit["id"]; ?>" class="table-block-values">
                    <td class="table-block-value-input-radio"><input type="radio" name="selectedUnit" checked="checked" value="<?php echo $unit["id"]; ?>"></td>
                    <td class="table-block-value-text"><?php echo $unit["name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $unit["designation"]; ?></td>
                </tr>
            <?php endif; ?>
        <? endforeach; ?>
    </table>
</div>