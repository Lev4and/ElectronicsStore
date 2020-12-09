<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Фото</th>
            <th class="table-block-header">Классификация</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($categories as $category): ?>
            <tr id="<?php echo $category["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedCategory" checked="checked" value="<?php echo $category["id"]; ?>"></td>
                <td class="table-block-value-image"><div><img src="/Resources/Images/Upload/<?php echo $category["photo"]; ?>"></div></td>
                <td class="table-block-value-text"><?php echo $category["classification_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $category["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>