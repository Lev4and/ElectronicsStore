<div class="classifications">
    <table class="table-classifications" border="1">
        <tr class="table-classifications-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="classification-photo" class="classification-photo">Фото</th>
            <th id="classification-name" class="classification-name">Название</th>
        </tr>
        <?php foreach ($classifications as $classification): ?>
            <tr id="<?php echo $classification["id"]; ?>" class="table-classifications-row-values">
                <td id="select" class="select"><input type="radio" name="selectedClassification" checked="checked" value="<?php echo $classification["id"]; ?>"></td>
                <td id="classification-photo" class="classification-photo"><img src="/Resources/Images/Upload/<?php echo $classification["photo"]; ?>"></td>
                <td id="classification-name" class="classification-name"><?php echo $classification["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>