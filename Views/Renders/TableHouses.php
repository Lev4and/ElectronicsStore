<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Страна</th>
            <th class="table-block-header">Регион</th>
            <th class="table-block-header">Город</th>
            <th class="table-block-header">Улица</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($houses as $house): ?>
            <tr id="<?php echo $house["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedHouse" checked="checked" value="<?php echo $house["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $house["country_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $house["region_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $house["city_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $house["street_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $house["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>