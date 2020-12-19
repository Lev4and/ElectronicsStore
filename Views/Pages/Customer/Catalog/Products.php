<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$minPriceProduct = QueryExecutor::getInstance()->getMinPriceProduct($_GET["categorySubcategoryId"]);
$maxPriceProduct = QueryExecutor::getInstance()->getMaxPriceProduct($_GET["categorySubcategoryId"]);

$minEvaluationProduct = QueryExecutor::getInstance()->getMinEvaluationProduct($_GET["categorySubcategoryId"]);
$maxEvaluationProduct = QueryExecutor::getInstance()->getMaxEvaluationProduct($_GET["categorySubcategoryId"]);

$categorySubcategory = QueryExecutor::getInstance()->getCategorySubcategory($_GET["categorySubcategoryId"]);
$characteristicQuantityUnitValues = QueryExecutor::getInstance()->getCharacteristicQuantityUnitValues(null, null, null, "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - <?php echo $categorySubcategory["name"]; ?></title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/CatalogProducts.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/Basket.js"></script>
    <script src="/JS/CatalogProducts.js"></script>
</head>
<body>
<div class="main">
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Menu.php";
    ?>
    <div class="content">
        <?php if(!Access::isAdministrator()): ?>
            <div class="header-block">
                <h1><?php echo QueryExecutor::getInstance()->getCategorySubcategory($_GET["categorySubcategoryId"])["name"]; ?></h1>
            </div>
            <div class="content-filters-block">
                <form id="filtersForm" action=".?categorySubcategoryId=<?php echo $_GET["categorySubcategoryId"]; ?>" method="post">
                    <fieldset class="filters-block">
                        <legend>Фильтры</legend>
                        <div class="filter">
                            <span>Производители</span>
                            <div>
                                <ul>
                                    <?php foreach (QueryExecutor::getInstance()->getManufacturersProducts($_GET["categorySubcategoryId"]) as $manufacturer): ?>
                                        <li><input type="checkbox" name="filters[manufacturers][]" value="<?php echo $manufacturer["manufacturer_id"]; ?>"><span><?php echo "{$manufacturer["manufacturer_name"]}"; ?></span></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php foreach (QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory(null, null, null, $_GET["categorySubcategoryId"], null, "") as $characteristic): ?>
                            <?php if(count(QueryExecutor::getInstance()->getCharacteristicQuantityUnitValues($characteristic["characteristic_id"], null, null, "")) > 0): ?>
                                <div class="filter">
                                    <span><?php echo $characteristic["characteristic_name"]; ?></span>
                                    <div>
                                        <ul>
                                            <?php foreach (QueryExecutor::getInstance()->getUsedCharacteristicQuantityUnitValues($characteristic["characteristic_id"], $_GET["categorySubcategoryId"]) as $value): ?>
                                                <li><input type="checkbox" name="filters[characteristics][<?php echo $characteristic["characteristic_id"] ?>][]" value="<?php echo $value["id"]; ?>"><span><?php echo "{$value["value"]} {$value["unit_designation"]}";; ?></span></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="filter">
                            <span>Минимальная стоимость</span>
                            <div>
                                <input type="number" name="filters[minPrice]" min="<?php echo $minPriceProduct["min_price"]; ?>" value="<?php echo $minPriceProduct["min_price"]; ?>" max="<?php echo $maxPriceProduct["max_price"]; ?>">
                            </div>
                        </div>
                        <div class="filter">
                            <span>Максимальная стоимость</span>
                            <div>
                                <input type="number" name="filters[maxPrice]" min="<?php echo $minPriceProduct["min_price"]; ?>" value="<?php echo $maxPriceProduct["max_price"]; ?>" max="<?php echo $maxPriceProduct["max_price"]; ?>">
                            </div>
                        </div>
                        <div class="filter">
                            <span>Минимальная оценка</span>
                            <div>
                                <input type="number" name="filters[minEvaluation]" step="0.1" min="<?php echo isset($minEvaluationProduct["min_evaluation"]) ? $minEvaluationProduct["min_evaluation"] : 1; ?>" value="<?php echo isset($minEvaluationProduct["min_evaluation"]) ? $minEvaluationProduct["min_evaluation"] : 1; ?>" max="<?php echo isset($maxEvaluationProduct["max_evaluation"]) ? $minEvaluationProduct["min_evaluation"] : 5; ?>">
                            </div>
                        </div>
                        <div class="filter">
                            <span>Максимальная оценка</span>
                            <div>
                                <input type="number" name="filters[maxEvaluation]" step="0.1" min="<?php echo isset($minEvaluationProduct["min_evaluation"]) ? $minEvaluationProduct["min_evaluation"] : 1; ?>" value="<?php echo isset($maxEvaluationProduct["max_evaluation"]) ? $maxEvaluationProduct["max_evaluation"] : 5; ?>" max="<?php echo isset($maxEvaluationProduct["max_evaluation"]) ? $maxEvaluationProduct["max_evaluation"] : 5; ?>">
                            </div>
                        </div>
                        <div class="reset-filters">
                            <input class="reset-filters-button" type="reset" name="action" value="Сбросить фильтры">
                        </div>
                        <div class="apply-filters">
                            <input class="apply-filters-button" type="button" name="action" onclick="onClickApply()" value="Применить">
                        </div>
                    </fieldset>
                </form>
                <div id="productsBlock" class="products-block">
                    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/ProductsBlock.php"; ?>
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