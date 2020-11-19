<div class="houses">
    <table class="table-houses" border="1">
        <tr class="table-houses-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="country-name" class="country-name">Страна</th>
            <th id="region-name" class="region-name">Регион</th>
            <th id="city-name" class="city-name">Город</th>
            <th id="street-name" class="street-name">Улица</th>
            <th id="house-name" class="house-name">Название</th>
        </tr>
        <?php foreach ($houses as $house): ?>
            <tr id="<?php echo $house["id"]; ?>" class="table-houses-row-values">
                <td id="select" class="select"><input type="radio" name="selectedHouse" checked="checked" value="<?php echo $house["id"]; ?>"></td>
                <td id="country-name" class="country-name"><?php echo $house["country_name"]; ?></td>
                <td id="region-name" class="region-name"><?php echo $house["region_name"]; ?></td>
                <td id="city-name" class="city-name"><?php echo $house["city_name"]; ?></td>
                <td id="street-name" class="street-name"><?php echo $house["street_name"]; ?></td>
                <td id="house-name" class="house-name"><?php echo $house["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>