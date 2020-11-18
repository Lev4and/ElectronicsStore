<div class="regions">
    <table class="table-regions" border="">
        <tr class="table-regions-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="country-name" class="country-name">Страна</th>
            <th id="region-name" class="region-name">Название</th>
        </tr>
        <?php foreach ($regions as $region): ?>
            <tr id="<?php echo $region["id"]; ?>" class="table-regions-row-values">
                <td id="select" class="select"><input type="radio" name="selectedRegion" checked="checked" value="<?php echo $region["id"]; ?>"></td>
                <td id="country-name" class="country-name"><?php echo $region["country_name"]; ?></td>
                <td id="region-name" class="region-name"><?php echo $region["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>