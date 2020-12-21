<div class="table-block">
    <table border="1">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Категория подкатегории</th>
            <th class="table-block-header">Фото</th>
            <th class="table-block-header">Производитель</th>
            <th class="table-block-header">Модель</th>
            <th class="table-block-header">Оценка</th>
            <th class="table-block-header">Цена</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr id="<?php echo $product["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="radio" name="selectedProduct" checked="checked" value="<?php echo $product["id"]; ?>"></td>
                <td class="table-block-value-text"><?php echo $product["category_subcategory_name"]; ?></td>
                <td class="table-block-value-image"><div><img src="/Resources/Images/Upload/<?php echo $product["photo"]; ?>"></div></td>
                <td class="table-block-value-text"><?php echo $product["manufacturer_name"]; ?></td>
                <td class="table-block-value-text"><?php echo $product["model"]; ?></td>
                <td class="table-block-value-text" style="text-align: center"><?php echo $product["evaluation"]; ?></td>
                <td class="table-block-value-text" style="text-align: center"><?php echo $product["price"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>