<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Раздел</th>
            <th class="table-block-header">Характеристика</th>
            <th class="table-block-header">Категория подкатегории</th>
            <th class="table-block-header">Используется при фильтрации</th>
            <th class="table-block-header">Используется как основная информация</th>
        </tr>
        <?php foreach ($characteristicsCategorySubcategory as $characteristicCategorySubcategory): ?>
            <tr id="<?php echo $characteristicCategorySubcategory["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedCharacteristicCategorySubcategory" checked="checked" value="<?php echo $characteristicCategorySubcategory["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $characteristicCategorySubcategory["section_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $characteristicCategorySubcategory["characteristic_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $characteristicCategorySubcategory["category_subcategory_name"]; ?></td>
                <td class="table-block-value-text" style="text-align: center"><?php echo $characteristicCategorySubcategory["use_when_filtering"] ? "Да" : "Нет"; ?></td>
                <td class="table-block-value-text" style="text-align: center"><?php echo $characteristicCategorySubcategory["use_when_displaying_as_basic_information"] ? "Да" : "Нет"; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>