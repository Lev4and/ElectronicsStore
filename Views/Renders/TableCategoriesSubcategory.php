<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Фото</th>
            <th class="table-block-header">Классификация</th>
            <th class="table-block-header">Категория</th>
            <th class="table-block-header">Подкатегория</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($categoriesSubcategory as $categorySubcategory): ?>
            <tr id="<?php echo $categorySubcategory["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedCategorySubcategory" checked="checked" value="<?php echo $categorySubcategory["id"]; ?>"></td>
                <td class="table-block-value-image"><div><img src="/Resources/Images/Upload/<?php echo $categorySubcategory["photo"]; ?>"></div></td>
                <td class="table-block-value-text"><?php echo $categorySubcategory["classification_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $categorySubcategory["category_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $categorySubcategory["subcategory_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $categorySubcategory["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>