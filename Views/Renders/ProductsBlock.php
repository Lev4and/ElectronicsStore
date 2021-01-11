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

function containsProductView($productId){
    if(Access::isAuthorized()){
        return QueryExecutor::getInstance()->containsProductView($productId, $_SESSION["user"]["id"]);
    }
    else{
        return in_array($productId, explode(", ", $_COOKIE["viewedProducts"]));
    }
}

function containsPurchasedByUserProduct($productId){
    if(Access::isAuthorized()){
        return QueryExecutor::getInstance()->containsPurchasedByUserProduct($productId, $_SESSION["user"]["id"]);
    }
    else{
        return in_array($productId, explode(", ", $_COOKIE["purchasedProducts"]));
    }
}

function containsProductFavorite($productId){
    if(Access::isAuthorized()){
        return QueryExecutor::getInstance()->containsFavoriteProduct($productId, $_SESSION["user"]["id"]);
    }
    else{
        return in_array($productId, explode(", ", $_COOKIE["favoriteProducts"]));
    }
}
?>
<?php foreach ($products as $key => $product): ?>
    <?php if($key >= ($_SESSION["pageNumber"] - 1) * 25 && $key <= $_SESSION["pageNumber"] * 25 - 1): ?>
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
                    <span><?php echo number_format($product["price"], 0, ",", " ") . " ₽";?></span>
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
                    <i class="far fa-comment-dots">
                        <span><?php echo $product["count_of_evaluations"]; ?></span>
                    </i>
                </span>
                </div>
                <div class="product-block-footer-block-statistical-information-block">
                    <div class="product-block-footer-block-statistical-information-block-column">
                        <i class="far fa-eye" <?php echo (containsProductView($product["id"]) ? "style='color: blue;'" : ""); ?>>
                            <span><?php echo isset($product["count_of_views"]) ? $product["count_of_views"] : 0; ?></span>
                        </i>
                    </div>
                    <div class="product-block-footer-block-statistical-information-block-column" style="flex-direction: column">
                        <div class="product-block-footer-block-statistical-information-block-column-row">
                            <i class="fas fa-shopping-bag" <?php echo (containsPurchasedByUserProduct($product["id"]) ? "style='color: lime;'" : ""); ?>>
                                <span><?php echo isset($product["sales"]) ? $product["sales"] : 0 ?></span>
                            </i>
                        </div>
                        <div class="product-block-footer-block-statistical-information-block-column-row">
                            <i id="count-of-likes-icon-<?php echo $product["id"]; ?>" class="far fa-heart" <?php echo (containsProductFavorite($product["id"]) ? "style='color: red;'" : ""); ?>>
                                <span id="count-of-likes-<?php echo $product["id"]; ?>"><?php echo $product["count_of_likes"]; ?></span>
                            </i>
                        </div>
                    </div>
                </div>
                <div class="product-block-footer-block-actions-block">
                    <div class="product-block-footer-block-action-block" style="width: 25%">
                        <button class="favorite-button" onmousemove="onMouseMoveFavoriteButton(this, <?php echo (containsProductFavorite($product["id"]) ? "true": "false"); ?>);" onmouseleave="onMouseLeaveFavoriteButton(this, <?php echo (containsProductFavorite($product["id"]) ? "true": "false"); ?>);" onclick="onClickFavoriteButton(this, <?php echo (containsProductFavorite($product["id"]) ? "true": "false"); ?>, <?php echo $product["id"]; ?>, <?php echo $_SESSION["user"]["id"]; ?>)"><i id="favorites-icon" class="<?php echo (containsProductFavorite($product["id"]) ? "fas fa-heart" : "far fa-heart"); ?>" style="color: blue;"></i></button>
                    </div>
                    <div class="product-block-footer-block-action-block" style="width: 70%">
                        <button onclick="onClickAddToCart(this, <?php echo $product["id"]; ?>);" <?php echo in_array(array("productId" => $product["id"]), $_SESSION["basket"]) ? "disabled='disabled'" : ""; ?>>В корзину</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>