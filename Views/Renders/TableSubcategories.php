<div class="subcategories">
    <table class="table-subcategories" border="1">
        <tr class="table-subcategories-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="subcategory-photo" class="subcategory-photo">Фото</th>
            <th id="classification-name" class="classification-name">Классификация</th>
            <th id="category-name" class="category-name">Категория</th>
            <th id="subcategory-name" class="subcategory-name">Название</th>
        </tr>
        <?php foreach ($subcategories as $subcategory): ?>
            <tr id="<?php echo $subcategory["id"]; ?>" class="table-subcategories-row-values">
                <td id="select" class="select"><input type="radio" name="selectedSubcategory" checked="checked" value="<?php echo $subcategory["id"]; ?>"></td>
                <td id="category-photo" class="category-photo"><img src="/Resources/Images/Upload/<?php echo $subcategory["photo"]; ?>"></td>
                <td id="classification-name" class="classification-name"><?php echo $subcategory["classification_name"]; ?></td>
                <td id="category-name" class="category-name"><?php echo $subcategory["category_name"]; ?></td>
                <td id="subcategory-name" class="subcategory-name"><?php echo $subcategory["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>