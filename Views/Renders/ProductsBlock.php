<?php
function getCoefficient($evaluation, $numberStar){
    if(!isset($evaluation)){
        return 0;
    }

    if($evaluation < $numberStar){
        return fmod($evaluation, ($numberStar - 1));
    }

    return 1;
}
?>
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
                <span>
                    <i class="far fa-star">
                        <i class="fas fa-star" style="width: <?php echo (asin(2 * getCoefficient($product["evaluation"], 1)  - 1) / pi() + 0.5) * 100; ?>%;"></i>
                    </i>
                    <i class="far fa-star">
                        <i class="fas fa-star" style="width: <?php echo (asin(2 * getCoefficient($product["evaluation"], 2) - 1) / pi() + 0.5) * 100; ?>%;"></i>
                    </i>
                    <i class="far fa-star">
                        <i class="fas fa-star" style="width: <?php echo (asin(2 * getCoefficient($product["evaluation"], 3) - 1) / pi() + 0.5) * 100; ?>%;"></i>
                    </i>
                    <i class="far fa-star">
                        <i class="fas fa-star" style="width: <?php echo (asin(2 * getCoefficient($product["evaluation"], 4) - 1) / pi() + 0.5) * 100; ?>%;"></i>
                    </i>
                    <i class="far fa-star">
                        <i class="fas fa-star" style="width: <?php echo (asin(2 * getCoefficient($product["evaluation"], 5) - 1) / pi() + 0.5) * 100; ?>%;"></i>
                    </i>
                    <?php echo $product["count_of_evaluations"]; ?>
                </span>
            </div>
            <div class="product-block-footer-block-actions-block">
                <div class="product-block-footer-block-action-block">
                    <button onclick="onClickAddToCart(this, <?php echo $product["id"]; ?>);" <?php echo in_array(array("productId" => $product["id"]), $_SESSION["basket"]) ? "disabled='disabled'" : ""; ?>>В корзину</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>