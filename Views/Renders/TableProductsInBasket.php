<div class="table-block">
    <table border="1" style="width: 100%">
        <tr class="table-block-headers">
            <th class="table-block-header">Выбрать</th>
            <th class="table-block-header">Фото</th>
            <th class="table-block-header">Название</th>
            <th class="table-block-header">Количество</th>
            <th class="table-block-header">Цена</th>
        </tr>
        <?php foreach ($_SESSION["basket"] as $item): ?>
            <?php $product = QueryExecutor::getInstance()->getProduct($item["productId"]); ?>
            <tr id="<?php echo $product["id"]; ?>" class="table-block-values">
                <td class="table-block-value-input-radio"><input type="hidden" name="basket[<?php echo $product["id"]; ?>][productId]" value="<?php echo $product["id"]; ?>"><input type="radio" name="selectedProduct" checked="checked" value="<?php echo $product["id"]; ?>"></td>
                <td class="table-block-value-image"><div><img src="/Resources/Images/Upload/<?php echo $product["photo"]; ?>"></div></td>
                <td class="table-block-value-text"><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/Product.php?productId={$product["id"]}" ?>" style="text-decoration: none; color: black"><?php echo "{$product["manufacturer_name"]} {$product["model"]}"; ?></a></td>
                <td class="table-block-value-input-number"><input type="number" name="basket[<?php echo $product["id"]; ?>][number]" min="1" onchange="numberItemsChanged();" value="1"></td>
                <td class="table-block-value-text" style="text-align: center"><input type="hidden" name="basket[<?php echo $product["id"]; ?>][price]" value="<?php echo "{$product["price"]}"; ?>"><?php echo "{$product["price"]} ₽"; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>