<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Страна</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($regions as $region): ?>
            <tr id="<?php echo $region["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedRegion" checked="checked" value="<?php echo $region["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $region["country_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $region["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>