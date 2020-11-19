<div class="streets">
    <table class="table-streets" border="1">
        <tr class="table-streets-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="country-name" class="country-name">Страна</th>
            <th id="region-name" class="region-name">Регион</th>
            <th id="city-name" class="city-name">Город</th>
            <th id="street-name" class="street-name">Название</th>
        </tr>
        <?php foreach ($streets as $street): ?>
            <tr id="<?php echo $street["id"]; ?>" class="table-streets-row-values">
                <td id="select" class="select"><input type="radio" name="selectedStreet" checked="checked" value="<?php echo $street["id"]; ?>"></td>
                <td id="country-name" class="country-name"><?php echo $street["country_name"]; ?></td>
                <td id="region-name" class="region-name"><?php echo $street["region_name"]; ?></td>
                <td id="city-name" class="city-name"><?php echo $street["city_name"]; ?></td>
                <td id="street-name" class="street-name"><?php echo $street["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>