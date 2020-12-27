<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$product = QueryExecutor::getInstance()->getProduct($_GET["productId"]);
$sectionsCategorySubcategoryProduct = QueryExecutor::getInstance()->getSectionsCategorySubcategoryProduct($_GET["productId"]);
$productCharacteristicsQuantityUnitValuesDetailedInformation = QueryExecutor::getInstance()->getProductCharacteristicsQuantityUnitValuesDetailedInformation($_GET["productId"]);
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
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/BreadcrumbList.css">
    <link rel="stylesheet" href="/CSS/Elements/Form.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/Basket.js"></script>
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
            <div class="form-block">
                <div class="form-block-information">
                    <div class="form-block-information-image-block">
                        <div class="form-block-information-image-block-container">
                            <img id="product-photo" name="photo" src="<?php echo "http://" . $_SERVER["SERVER_NAME"] . "/Resources/Images/Upload/" . $product["photo"]; ?>">
                        </div>
                    </div>
                    <div class="form-block-information-block">
                        <div class="form-block-information-block-row">
                            <div class="form-block-information-block-column">
                                <span><?php echo "{$product["manufacturer_name"]} {$product["model"]}"; ?></span>
                            </div>
                        </div>
                        <div class="form-block-information-block-row">
                            <div id="form-block-information-block-column" class="form-block-information-block-column">
                                <div class="form-block-information-block-column-row">
                                    <div class="form-block-information-block-column-row-column">
                                        <span><?php echo "{$product["price"]} ₽"; ?></span>
                                    </div>
                                </div>
                                <div class="form-block-information-block-column-row">
                                    <div id="form-block-information-block-column-row-column-evaluation-block" class="form-block-information-block-column-row-column">
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
                                        </span>
                                    </div>
                                    <div class="form-block-information-block-column-row-column">
                                        <span><?php echo $product["count_of_evaluations"]; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div id="form-block-information-block-column-button" class="form-block-information-block-column">
                                <button onclick="onClickAddToCart(this, <?php echo $product["id"]; ?>);" <?php echo in_array(array("productId" => $product["id"]), $_SESSION["basket"]) ? "disabled='disabled'" : ""; ?>>В корзину</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-block-description">
                    <fieldset class="form-block-description-fieldset">
                        <legend>Описание товара</legend>
                        <div class="form-block-description-fieldset-textarea-block">
                            <textarea disabled="disabled" name="description"><?php echo $product["description"]; ?></textarea>
                        </div>
                    </fieldset>
                </div>
                <div class="form-block-characteristics">
                    <fieldset class="form-block-characteristics-fieldset">
                        <legend>Характеристики</legend>
                        <div id="characteristics-block" class="form-block-description-fieldset-characteristics-block">
                            <?php foreach ($sectionsCategorySubcategoryProduct as $sectionCategorySubcategoryProduct): ?>
                                <div class="form-block-row" style="margin: 25px 0">
                                    <div id="form-block-row-column-label" class="form-block-row-column">
                                        <div class="form-block-row-column-label">
                                            <label style="text-align: left; font-weight: bold"><?php echo $sectionCategorySubcategoryProduct["section_name"]; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <?php foreach ($productCharacteristicsQuantityUnitValuesDetailedInformation as $characteristicsQuantityUnitValue): ?>
                                    <?php if($characteristicsQuantityUnitValue["section_category_subcategory_id"] == $sectionCategorySubcategoryProduct["section_category_subcategory_id"]): ?>
                                        <div class="form-block-row">
                                            <div id="form-block-row-column-label" class="form-block-row-column">
                                                <div class="form-block-row-column-label">
                                                    <label style="text-align: left"><?php echo $characteristicsQuantityUnitValue["characteristic_name"]; ?></label>
                                                </div>
                                            </div>
                                            <div id="form-block-row-column-input" class="form-block-row-column">
                                                <div class="form-block-row-column-label">
                                                    <label style="text-align: left"><?php echo "{$characteristicsQuantityUnitValue["value"]} {$characteristicsQuantityUnitValue["unit_designation"]}"; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>
                    </fieldset>
                </div>
                <div class="form-block-reviews">
                    <fieldset class="form-block-reviews-fieldset">
                        <legend>Отзывы</legend>

                    </fieldset>
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