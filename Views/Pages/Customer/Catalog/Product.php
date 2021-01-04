<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

if(Access::isAuthorized()){
    QueryExecutor::getInstance()->addProductView($_GET["productId"], $_SESSION["user"]["id"]);
}
else{
    $viewedProducts = "";
    $viewedProducts = $_COOKIE["viewedProducts"];
    $viewedProducts .= (iconv_strlen($_COOKIE["viewedProducts"], "UTF-8") > 0 ? ", {$_GET["productId"]}" : "{$_GET["productId"]}");

    setcookie("viewedProducts", $viewedProducts, time() + 3600 * 24 * 365, "/");
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";

$product = QueryExecutor::getInstance()->getProduct($_GET["productId"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - <?php echo "{$product["category_subcategory_name"]} {$product["manufacturer_name"]} {$product["model"]}"; ?></title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/Product.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/BreadcrumbList.css">
    <link rel="stylesheet" href="/CSS/Elements/MediaViewer.css">
    <link rel="stylesheet" href="/CSS/Elements/ProductTabDescription.css">
    <link rel="stylesheet" href="/CSS/Elements/ProductTabCharacteristics.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <link rel="stylesheet" href="/Resources/Packages/Slick/slick/slick.css"/>
    <link rel="stylesheet" href="/Resources/Packages/Slick/slick/slick-theme.css"/>
    <link rel="stylesheet" href="/CSS/Elements/Slider.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/Basket.js"></script>
    <script src="/JS/MediaViewer.js"></script>
    <script src="/JS/Favorites.js"></script>
    <script src="/JS/Tabs.js"></script>
</head>
<body>
<div class="main">
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Menu.php";
    ?>
    <div class="content">
        <?php if(!Access::isAdministrator()): ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/BreadcrumbList.php"; ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MediaViewer.php"; ?>
            <div class="product-block">
                <div class="product-block-information">
                    <div class="product-block-information-slider-block">
                        <div class="product-block-information-slider-block-container">
                            <div id="product-photos" class="slider">
                                <?php foreach (QueryExecutor::getInstance()->getProductPhotos($_GET["productId"]) as $photo): ?>
                                    <div class="slider__item filter">
                                        <img src="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Resources/Images/Upload/{$photo["photo"]}"; ?>" onclick="onClickSliderItemProduct(this);">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <script type="text/javascript" src="/Resources/Packages/Slick/slick/slick.min.js"></script>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('.slider').slick({
                                        arrows:true,
                                        dots:true,
                                        slidesToShow:1,
                                        autoplay:true,
                                        speed:1000,
                                        autoplaySpeed:5000,
                                        responsive:[
                                            {
                                                breakpoint: 768,
                                                settings: {
                                                    slidesToShow:2
                                                }
                                            },
                                            {
                                                breakpoint: 550,
                                                settings: {
                                                    slidesToShow:1
                                                }
                                            }
                                        ]
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    <div class="product-block-information-block">
                        <div class="product-block-information-block-row">
                            <div class="product-block-information-block-column">
                                <span style="text-align: center;"><?php echo "{$product["manufacturer_name"]} {$product["model"]}"; ?></span>
                            </div>
                            <div class="product-block-information-block-column">
                                <div class="product-block-information-block-column-manufacturer">
                                    <div class="product-block-information-block-column-manufacturer-image-container">
                                        <a href="ProductsManufacturer.php?manufacturerId=<?php echo $product["manufacturer_id"]; ?>"><img src="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Resources/Images/Upload/{$product["manufacturer_photo"]}"; ?>"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-block-information-block-row">
                            <div id="product-block-information-block-column" class="product-block-information-block-column">
                                <div class="product-block-information-block-column-row">
                                    <div class="product-block-information-block-column-row-column">
                                        <span style="font-size: 36px;"><?php echo number_format($product["price"], 0, ",", " ") . " ₽"; ?></span>
                                    </div>
                                </div>
                                <div class="product-block-information-block-column-row">
                                    <div id="product-block-information-block-column-row-column-evaluation-block" class="product-block-information-block-column-row-column">
                                        <span>
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
                                    <?php
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
                                    <div id="product-block-information-block-column-row-column-statistical-information-block" class="product-block-information-block-column-row-column">
                                        <div class="product-block-information-block-column-row-column-statistical-information-block-column">
                                            <i class="far fa-eye" <?php echo (containsProductView($product["id"]) ? "style='color: blue;'" : ""); ?>>
                                                <span><?php echo isset($product["count_of_views"]) ? $product["count_of_views"] : 0; ?></span>
                                            </i>
                                        </div>
                                        <div class="product-block-information-block-column-row-column-statistical-information-block-column" style="flex-direction: column">
                                            <div class="product-block-information-block-column-row-column-statistical-information-block-column-row">
                                                <i class="fas fa-shopping-bag" <?php echo (containsPurchasedByUserProduct($product["id"]) ? "style='color: lime;'" : ""); ?>>
                                                    <span><?php echo isset($product["sales"]) ? $product["sales"] : 0 ?></span>
                                                </i>
                                            </div>
                                            <div class="product-block-information-block-column-row-column-statistical-information-block-column-row">
                                                <i id="count-of-likes-icon-<?php echo $product["id"]; ?>" class="far fa-heart" <?php echo (containsProductFavorite($product["id"]) ? "style='color: red;'" : ""); ?>>
                                                    <span id="count-of-likes-<?php echo $product["id"]; ?>"><?php echo $product["count_of_likes"]; ?></span>
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="product-block-information-block-column-button" class="product-block-information-block-column">
                                <button class="favorite-button" onmousemove="onMouseMoveFavoriteButton(this, <?php echo (containsProductFavorite($product["id"]) ? "true": "false"); ?>);" onmouseleave="onMouseLeaveFavoriteButton(this, <?php echo (containsProductFavorite($product["id"]) ? "true": "false"); ?>);" onclick="onClickFavoriteButton(this, <?php echo (containsProductFavorite($product["id"]) ? "true": "false"); ?>, <?php echo $product["id"]; ?>, <?php echo $_SESSION["user"]["id"]; ?>)" style="width: 50%; font-size: larger"><i id="favorites-icon" class="<?php echo (containsProductFavorite($product["id"]) ? "fas fa-heart" : "far fa-heart"); ?>" style="color: blue;"></i></button>
                            </div>
                            <div id="product-block-information-block-column-button" class="product-block-information-block-column">
                                <button onclick="onClickAddToCart(this, <?php echo $product["id"]; ?>);" <?php echo in_array(array("productId" => $product["id"]), $_SESSION["basket"]) ? "disabled='disabled'" : ""; ?>>В корзину</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-block-tabs">
                    <div id="product-block-tab-active" class="product-block-tab" onclick="onClickTab(this, 'Описание', <?php echo $product["id"]; ?>)">
                        <span>Описание</span>
                    </div>
                    <div class="product-block-tab" onclick="onClickTab(this, 'Характеристики', <?php echo $product["id"]; ?>)">
                        <span>Характеристики</span>
                    </div>
                    <div class="product-block-tab" onclick="onClickTab(this, 'Отзывы', <?php echo $product["id"]; ?>)">
                        <span>Отзывы <?php echo $product["count_of_evaluations"]; ?></span>
                    </div>
                    <div class="product-block-tab" onclick="onClickTab(this, 'Комментарии', <?php echo $product["id"]; ?>)">
                        <span>Комментарии</span>
                    </div>
                    <div class="product-block-tab" onclick="onClickTab(this, 'Вопрос-Ответ', <?php echo $product["id"]; ?>)">
                        <span>Вопрос-Ответ</span>
                    </div>
                </div>
                <div class="product-block-tab-content">
                    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/ProductTabDescription.php"; ?>
                </div>
            </div>
            <?php VisibleError::showError(); ?>
        <?php else: ?>
            <?php Access::denyAccess(); ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>