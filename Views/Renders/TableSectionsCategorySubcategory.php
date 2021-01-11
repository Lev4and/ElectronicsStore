<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Раздел</th>
            <th class="table-block-header">Классификация</th>
            <th class="table-block-header">Категория</th>
            <th class="table-block-header">Подкатегория</th>
            <th class="table-block-header">Категория подкатегории</th>
        </tr>
        <?php foreach ($sectionsCategorySubcategory as $key => $sectionCategorySubcategory): ?>
            <?php if($key >= ($_SESSION["pageNumber"] - 1) * 25 && $key <= $_SESSION["pageNumber"] * 25 - 1): ?>
                <tr id="<?php echo $sectionCategorySubcategory["id"]; ?>" class="table-block-values">
                    <td class="table-block-value-input-radio"><input type="radio" name="selectedSectionCategorySubcategory" checked="checked" value="<?php echo $sectionCategorySubcategory["id"]; ?>"></td>
                    <td class="table-block-value-text"><?php echo $sectionCategorySubcategory["section_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $sectionCategorySubcategory["classification_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $sectionCategorySubcategory["category_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $sectionCategorySubcategory["subcategory_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $sectionCategorySubcategory["category_subcategory_name"]; ?></td>
                </tr>
            <?php endif; ?>
        <? endforeach; ?>
    </table>
</div>