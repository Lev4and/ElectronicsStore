<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Название</th>
        </tr>
        <?php foreach ($evaluationCriterions as $evaluationCriterion): ?>
            <tr id="<?php echo $evaluationCriterion["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedEvaluationCriterion" checked="checked" value="<?php echo $evaluationCriterion["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $evaluationCriterion["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>