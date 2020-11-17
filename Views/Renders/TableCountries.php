<div class="countries">
    <table class="table-countries" border="1">
        <tr class="table-countries-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="country-flag" class="country-flag">Флаг</th>
            <th id="country-name" class="country-name">Название</th>
        </tr>
        <?php foreach ($countries as $country): ?>
            <tr id="<?php echo $country["id"]; ?>" class="table-countries-row-values">
                <td id="select" class="select"><input type="radio" name="selectedCountry" checked="checked" value="<?php echo $country["id"]; ?>"></td>
                <td id="country-flag" class="country-flag"><img src="/Resources/Images/Upload/<?php echo $country["flag"]; ?>"></td>
                <td id="country-name" class="country-name"><?php echo $country["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>