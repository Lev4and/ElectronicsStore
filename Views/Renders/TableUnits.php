<div class="units">
    <table class="table-units" border="1">
        <tr class="table-units-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="unit-name" class="unit-name">Название</th>
            <th id="unit-designation" class="unit-designation">Обозначение</th>
        </tr>
        <?php foreach ($units as $unit): ?>
            <tr id="<?php echo $unit["id"]; ?>" class="table-units-row-values">
                <td id="select" class="select"><input type="radio" name="selectedUnit" checked="checked" value="<?php echo $unit["id"]; ?>"></td>
                <td id="unit-name" class="unit-name"><?php echo $unit["name"]; ?></td>
                <td id="unit-designation" class="unit-designation"><?php echo $unit["designation"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>