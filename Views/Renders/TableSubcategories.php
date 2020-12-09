<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Фото</th>
            <th class="table-block-header">Классификация</th>
            <th class="table-block-header">Категория</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($subcategories as $subcategory): ?>
            <tr id="<?php echo $subcategory["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedSubcategory" checked="checked" value="<?php echo $subcategory["id"]; ?>"></td>
                <td class="table-block-value-image"><div><img src="/Resources/Images/Upload/<?php echo $subcategory["photo"]; ?>"></div></td>
                <td class="table-block-value-text"><?php echo $subcategory["classification_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $subcategory["category_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $subcategory["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>