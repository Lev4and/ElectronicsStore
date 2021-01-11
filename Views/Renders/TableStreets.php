<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Страна</th>
            <th class="table-block-header">Регион</th>
            <th class="table-block-header">Город</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($streets as $key => $street): ?>
            <?php if($key >= ($_SESSION["pageNumber"] - 1) * 25 && $key <= $_SESSION["pageNumber"] * 25 - 1): ?>
                <tr id="<?php echo $street["id"]; ?>" class="table-block-values">
                    <td class="table-block-value-input-radio"><input type="radio" name="selectedStreet" checked="checked" value="<?php echo $street["id"]; ?>"></td>
                    <td class="table-block-value-text"><?php echo $street["country_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $street["region_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $street["city_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $street["name"]; ?></td>
                </tr>
            <?php endif; ?>
        <? endforeach; ?>
    </table>
</div>