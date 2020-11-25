<div class="characteristics">
    <table class="table-characteristics" border="1">
        <tr class="table-characteristics-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="characteristics-name" class="characteristics-name">Название</th>
        </tr>
        <?php foreach ($characteristics as $characteristic): ?>
            <tr id="<?php echo $characteristic["id"]; ?>" class="table-characteristics-row-values">
                <td id="select" class="select"><input type="radio" name="selectedCharacteristic" checked="checked" value="<?php echo $characteristic["id"]; ?>"></td>
                <td id="characteristics-name" class="characteristics-name"><?php echo $characteristic["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>