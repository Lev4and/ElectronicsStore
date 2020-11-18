<div class="cities">
    <table class="table-cities" border="1">
        <tr class="table-cities-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="country-name" class="country-name">Страна</th>
            <th id="region-name" class="region-name">Регион</th>
            <th id="city-name" class="city-name">Название</th>
        </tr>
        <?php foreach ($cities as $city): ?>
            <tr id="<?php echo $city["id"]; ?>" class="table-cities-row-values">
                <td id="select" class="select"><input type="radio" name="selectedCity" checked="checked" value="<?php echo $city["id"]; ?>"></td>
                <td id="country-name" class="country-name"><?php echo $city["country_name"]; ?></td>
                <td id="region-name" class="region-name"><?php echo $city["region_name"]; ?></td>
                <td id="city-name" class="city-name"><?php echo $city["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>