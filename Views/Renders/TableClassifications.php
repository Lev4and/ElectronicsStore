<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Фото</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($classifications as $key => $classification): ?>
            <?php if($key >= ($_SESSION["pageNumber"] - 1) * 25 && $key <= $_SESSION["pageNumber"] * 25 - 1): ?>
                <tr id="<?php echo $classification["id"]; ?>" class="table-block-values">
                    <td class="table-block-value-input-radio"><input type="radio" name="selectedClassification" checked="checked" value="<?php echo $classification["id"]; ?>"></td>
                    <td class="table-block-value-image"><div><img src="/Resources/Images/Upload/<?php echo $classification["photo"]; ?>"></div></td>
                    <td class="table-block-value-text"><?php echo $classification["name"]; ?></td>
                </tr>
            <?php endif; ?>
        <? endforeach; ?>
    </table>
</div>