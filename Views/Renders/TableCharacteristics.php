<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($characteristics as $characteristic): ?>
            <tr id="<?php echo $characteristic["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedCharacteristic" checked="checked" value="<?php echo $characteristic["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $characteristic["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>