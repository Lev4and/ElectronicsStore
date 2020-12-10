<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Название</th>
            <th class="table-block-header">Обозначение</th>
        </tr>
        <?php foreach ($meters as $meter): ?>
            <tr id="<?php echo $meter["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedMeter" checked="checked" value="<?php echo $meter["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $meter["name"]; ?></td>
                <td class="table-block-value-text"><?php echo $meter["designation"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>