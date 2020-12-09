<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Фото</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($manufacturers as $manufacturer): ?>
            <tr id="<?php echo $manufacturer["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedManufacturer" checked="checked" value="<?php echo $manufacturer["id"]; ?>"></td>
                <td class="table-block-value-image"><div><img src="/Resources/Images/Upload/<?php echo $manufacturer["photo"]; ?>"></div></td>
                <td class="table-block-value-text"><?php echo $manufacturer["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>