<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Флаг</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($countries as $key => $country): ?>
            <?php if($key >= ($_SESSION["pageNumber"] - 1) * 25 && $key <= $_SESSION["pageNumber"] * 25 - 1): ?>
                <tr id="<?php echo $country["id"]; ?>" class="table-block-values">
                    <td class="table-block-value-input-radio"><input type="radio" name="selectedCountry" checked="checked" value="<?php echo $country["id"]; ?>"></td>
                    <td class="table-block-value-image"><div><img src="/Resources/Images/Upload/<?php echo $country["flag"]; ?>"></div></td>
                    <td class="table-block-value-text"><?php echo $country["name"]; ?></td>
                </tr>
            <?php endif; ?>
        <? endforeach; ?>
    </table>
</div>