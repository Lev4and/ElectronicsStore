<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($sections as $key => $section): ?>
            <?php if($key >= ($_SESSION["pageNumber"] - 1) * 25 && $key <= $_SESSION["pageNumber"] * 25 - 1): ?>
                <tr id="<?php echo $section["id"]; ?>" class="table-block-values">
                    <td class="table-block-value-input-radio"><input type="radio" name="selectedSection" checked="checked" value="<?php echo $section["id"]; ?>"></td>
                    <td class="table-block-value-text"><?php echo $section["name"]; ?></td>
                </tr>
            <?php endif; ?>
        <? endforeach; ?>
    </table>
</div>