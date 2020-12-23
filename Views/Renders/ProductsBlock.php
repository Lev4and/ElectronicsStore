<?php foreach ($products as $product): ?>
    <div class="product-block">
        <div class="product-block-main-block">
            <div class="product-block-main-block-image-container">
                <img src="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Resources/Images/Upload/{$product["photo"]}"; ?>">
            </div>
            <div class="product-block-main-block-information-block">
                <a href="<?php echo "Product.php?productId={$product["id"]}"; ?>">
                    <span><?php echo "{$product["manufacturer_name"]} {$product["model"]}"; ?></span>
                </a>
            </div>
            <div class="product-block-main-block-price-block">
                <span><?php echo $product["price"]; ?> ₽</span>
            </div>
        </div>
        <div class="product-block-characteristics-block">
            <span>
                <?php
                $characteristics = array();

                foreach (QueryExecutor::getInstance()->getProductCharacteristicsQuantityUnitValuesDetailedInformation($product["id"], 1) as $value){
                    array_push($characteristics, "{$value["value"]}" . (iconv_strlen($value["unit_designation"], "UTF-8") > 0 ? " {$value["unit_designation"]}" : ""));
                }

                echo implode(", ", $characteristics);
                ?>
            </span>
        </div>
        <div class="product-block-footer-block">
            <div class="product-block-footer-block-evaluation-block">
                <span>Оценка: <?php echo isset($product["evaluation"]) && $product["evaluation"] >= 1 ? $product["evaluation"] : "Неизвестно"; ?></span>
            </div>
            <div class="product-block-footer-block-actions-block">
                <div class="product-block-footer-block-action-block">
                    <button onclick="onClickAddToCart(this, <?php echo $product["id"]; ?>);" <?php echo in_array(array("productId" => $product["id"]), $_SESSION["basket"]) ? "disabled='disabled'" : ""; ?>>В корзину</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>