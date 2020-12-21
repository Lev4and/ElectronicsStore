<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($sections as $section): ?>
            <tr id="<?php echo $section["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedSection" checked="checked" value="<?php echo $section["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $section["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>