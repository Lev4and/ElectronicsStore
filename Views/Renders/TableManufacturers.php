<div class="manufacturers">
    <table class="table-manufacturers" border="1">
        <tr class="table-manufacturers-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="manufacturer-photo" class="manufacturer-photo">Фото</th>
            <th id="manufacturer-name" class="manufacturer-name">Название</th>
        </tr>
        <?php foreach ($manufacturers as $manufacturer): ?>
            <tr id="<?php echo $manufacturer["id"]; ?>" class="table-manufacturers-row-values">
                <td id="select" class="select"><input type="radio" name="selectedManufacturer" checked="checked" value="<?php echo $manufacturer["id"]; ?>"></td>
                <td id="manufacturer-photo" class="manufacturer-photo"><img src="/Resources/Images/Upload/<?php echo $manufacturer["photo"]; ?>"></td>
                <td id="manufacturer-name" class="manufacturer-name"><?php echo $manufacturer["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>