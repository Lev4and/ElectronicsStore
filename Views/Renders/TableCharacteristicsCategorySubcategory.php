<div class="characteristics-category-subcategory">
    <table class="table-characteristics-category-subcategory" border="1">
        <tr class="table-characteristics-category-subcategory-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="characteristic-name" class="characteristic-name">Характеристика</th>
            <th id="category-subcategory-name" class="category-subcategory-name">Категория подкатегории</th>
            <th id="subcategory-name" class="subcategory-name">Подкатегория</th>
            <th id="category-name" class="category-name">Категория</th>
            <th id="classification-name" class="classification-name">Классификация</th>
        </tr>
        <?php foreach ($characteristicsCategorySubcategory as $characteristicCategorySubcategory): ?>
            <tr id="<?php echo $characteristicCategorySubcategory["id"]; ?>" class="table-characteristics-category-subcategory-row-values">
                <td id="select" class="select"><input type="radio" name="selectedCharacteristicCategorySubcategory" checked="checked" value="<?php echo $characteristicCategorySubcategory["id"]; ?>"></td>
                <td id="characteristic-name" class="characteristic-name"><?php echo $characteristicCategorySubcategory["characteristic_name"]; ?></td>
                <td id="category-subcategory-name" class="category-subcategory-name"><?php echo $characteristicCategorySubcategory["category_subcategory_name"]; ?></td>
                <td id="subcategory-name" class="subcategory-name"><?php echo $characteristicCategorySubcategory["subcategory_name"]; ?></td>
                <td id="category-name" class="category-name"><?php echo $characteristicCategorySubcategory["category_name"]; ?></td>
                <td id="classification-name" class="classification-name"><?php echo $characteristicCategorySubcategory["classification_name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>