<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Флаг</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($countries as $country): ?>
            <tr id="<?php echo $country["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedCountry" checked="checked" value="<?php echo $country["id"]; ?>"></td>
                <td class="table-block-value-image"><div><img src="/Resources/Images/Upload/<?php echo $country["flag"]; ?>"></div></td>
                <td class="table-block-value-text"><?php echo $country["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>