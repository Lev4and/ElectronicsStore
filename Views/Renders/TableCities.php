<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Страна</th>
            <th class="table-block-header">Регион</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($cities as $city): ?>
            <tr id="<?php echo $city["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedCity" checked="checked" value="<?php echo $city["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $city["country_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $city["region_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $city["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>