<div class="categories-subcategory">
    <table class="table-categories-subcategory" border="1">
        <tr class="table-categories-subcategory-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="category-subcategory-photo" class="category-subcategory-photo">Фото</th>
            <th id="classification-name" class="classification-name">Классификация</th>
            <th id="category-name" class="category-name">Категория</th>
            <th id="subcategory-name" class="subcategory-name">Подкатегория</th>
            <th id="category-subcategory-name" class="category-subcategory-name">Название</th>
        </tr>
        <?php foreach ($categoriesSubcategory as $categorySubcategory): ?>
            <tr id="<?php echo $categorySubcategory["id"]; ?>" class="table-categories-subcategory-row-values">
                <td id="select" class="select"><input type="radio" name="selectedCategorySubcategory" checked="checked" value="<?php echo $categorySubcategory["id"]; ?>"></td>
                <td id="category-subcategory-photo" class="category-subcategory-photo"><img src="/Resources/Images/Upload/<?php echo $categorySubcategory["photo"]; ?>"></td>
                <td id="classification-name" class="classification-name"><?php echo $categorySubcategory["classification_name"]; ?></td>
                <td id="category-name" class="category-name"><?php echo $categorySubcategory["category_name"]; ?></td>
                <td id="subcategory-name" class="subcategory-name"><?php echo $categorySubcategory["subcategory_name"]; ?></td>
                <td id="category-subcategory-name" class="category-subcategory-name"><?php echo $categorySubcategory["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>