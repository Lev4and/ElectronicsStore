<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Название</th>
            <th class="table-block-header">Классификация</th>
            <th class="table-block-header">Категория</th>
            <th class="table-block-header">Подкатегория</th>
            <th class="table-block-header">Категория подкатегории</th>
        </tr>
        <?php foreach ($evaluationCriterionsCategorySubcategory as $key => $evaluationCriterionCategorySubcategory): ?>
            <?php if($key >= ($_SESSION["pageNumber"] - 1) * 25 && $key <= $_SESSION["pageNumber"] * 25 - 1): ?>
                <tr id="<?php echo $evaluationCriterionCategorySubcategory["id"]; ?>" class="table-block-values">
                    <td class="table-block-value-input-radio"><input type="radio" name="selectedEvaluationCriterionCategorySubcategory" checked="checked" value="<?php echo $evaluationCriterionCategorySubcategory["id"]; ?>"></td>
                    <td class="table-block-value-text"><?php echo $evaluationCriterionCategorySubcategory["evaluation_criterion_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $evaluationCriterionCategorySubcategory["classification_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $evaluationCriterionCategorySubcategory["category_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $evaluationCriterionCategorySubcategory["subcategory_name"]; ?></td>
                    <td class="table-block-value-text"><?php echo $evaluationCriterionCategorySubcategory["category_subcategory_name"]; ?></td>
                </tr>
            <?php endif; ?>
        <? endforeach; ?>
    </table>
</div>