<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
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
    <link rel="stylesheet" href="/CSS/Elements/Pagination.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/BreadcrumbList.css">
    <link rel="stylesheet" href="/CSS/Elements/FilterArrowLeft.css">
    <link rel="stylesheet" href="/CSS/Elements/MultiRange.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <link rel="stylesheet" href="/Resources/Packages/Nouislider/nouislider.min.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/Basket.js"></script>
    <script src="/JS/Filter.js"></script>
    <script src="/JS/Favorites.js"></script>
    <script src="/JS/Pagination.js"></script>
    <script src="/JS/CatalogProducts.js"></script>
</head>
<body>
<div class="main">
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Menu.php";
    ?>
    <script>init(<?php echo $_GET["categorySubcategoryId"]; ?>);</script>
    <div class="content">
        <?php if(!Access::isAdministrator()): ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/BreadcrumbList.php"; ?>
            <div class="content-counter-products">
                <span><?php echo $categorySubcategory["name"]; ?> <span id="counter-products"><?php echo NumWord::numberWord(count($products), array('товар', 'товара', 'товаров')); ?></span></span>
            </div>
            <div class="content-container-block">
                <form id="filtersForm" action=".?categorySubcategoryId=<?php echo $_GET["categorySubcategoryId"]; ?>" method="post">
                    <fieldset class="filters-block">
                        <legend>Фильтры</legend>
                        <div class="filter">
                            <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                <div class="filter-title"><i class="fas fa-chevron-up"></i><span>Сортировка</span></div>
                            </div>
                            <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                <ul>
                                    <li><input type="radio" name="sortMode" checked="checked" value="0"><span>По возрастанию цены</span></li>
                                    <li><input type="radio" name="sortMode" value="1"><span>По убыванию цены</span></li>
                                    <li><input type="radio" name="sortMode" value="2"><span>По популярности (Самые популярные)</span></li>
                                    <li><input type="radio" name="sortMode" value="3"><span>По популярности (Самые непопулярные)</span></li>
                                    <li><input type="radio" name="sortMode" value="4"><span>По наименованию (A-Z А-Я)</span></li>
                                    <li><input type="radio" name="sortMode" value="5"><span>По наименованию (Я-А Z-A)</span></li>
                                    <li><input type="radio" name="sortMode" value="6"><span>Обсуждаемые (Самые обсуждаемые)</span></li>
                                    <li><input type="radio" name="sortMode" value="7"><span>Обсуждаемые (Самые необсуждаемые)</span></li>
                                    <li><input type="radio" name="sortMode" value="8"><span>По рейтингу (Самые лучшие)</span></li>
                                    <li><input type="radio" name="sortMode" value="9"><span>По рейтингу (Самые худшие)</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="filter">
                            <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                <div class="filter-title"><i class="fas fa-chevron-up"></i><span>Группировка</span></div>
                            </div>
                            <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                <ul>
                                    <li><input type="radio" name="groupMode" checked="checked" value="0"><span>Без группировки</span></li>
                                    <li><input type="radio" name="groupMode" value="1"><span>По производителю</span></li>
                                    <li><input type="radio" name="groupMode" value="2"><span>По наличию</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="filter">
                            <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                <div class="filter-title"><i class="fas fa-chevron-up"></i><span>Стоимость</span></div>
                            </div>
                            <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                <div class="multi-range">
                                    <div class="multi-range-double-number">
                                        <div class="multi-range-double-number-container-number">
                                            <input class="begin-range" type="number" name="filters[minPrice]" min="<?php echo $minPriceProduct["min_price"]; ?>" value="<?php echo $minPriceProduct["min_price"]; ?>" max="<?php echo $maxPriceProduct["max_price"]; ?>">
                                        </div>
                                        <div class="multi-range-double-number-container-number">
                                            <input class="end-range" type="number" name="filters[maxPrice]" min="<?php echo $minPriceProduct["min_price"]; ?>" value="<?php echo $maxPriceProduct["max_price"]; ?>" max="<?php echo $maxPriceProduct["max_price"]; ?>">
                                        </div>
                                    </div>
                                    <div class="multi-range-slider-container">
                                        <div id="multi-range-slider-price" class="multi-range-slider">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter">
                            <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                <div class="filter-title"><i class="fas fa-chevron-up"></i><span>Оценка</span></div>
                            </div>
                            <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                <div class="multi-range">
                                    <div class="multi-range-double-number">
                                        <div class="multi-range-double-number-container-number">
                                            <input class="begin-range" type="number" name="filters[minEvaluation]" step="0.1" min="<?php echo isset($minEvaluationProduct["min_evaluation"]) ? $minEvaluationProduct["min_evaluation"] : 1; ?>" value="<?php echo isset($minEvaluationProduct["min_evaluation"]) ? $minEvaluationProduct["min_evaluation"] : 1; ?>" max="<?php echo isset($maxEvaluationProduct["max_evaluation"]) ? $minEvaluationProduct["min_evaluation"] : 5; ?>">
                                        </div>
                                        <div class="multi-range-double-number-container-number">
                                            <input class="end-range" type="number" name="filters[maxEvaluation]" step="0.1" min="<?php echo isset($minEvaluationProduct["min_evaluation"]) ? $minEvaluationProduct["min_evaluation"] : 1; ?>" value="<?php echo isset($maxEvaluationProduct["max_evaluation"]) ? $maxEvaluationProduct["max_evaluation"] : 5; ?>" max="<?php echo isset($maxEvaluationProduct["max_evaluation"]) ? $maxEvaluationProduct["max_evaluation"] : 5; ?>">
                                        </div>
                                    </div>
                                    <div class="multi-range-slider-container">
                                        <div id="multi-range-slider-evaluation" class="multi-range-slider">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php foreach (QueryExecutor::getInstance()->getEvaluationCriterionsCategorySubcategory(null, null, null, null, $_GET["categorySubcategoryId"], "") as $evaluationCriterion): ?>
                            <div class="filter">
                                <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                    <div class="filter-title"><i class="fas fa-chevron-up"></i><span><?php echo $evaluationCriterion["evaluation_criterion_name"]; ?></span></div>
                                </div>
                                <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                    <div class="multi-range">
                                        <div class="multi-range-double-number">
                                            <div class="multi-range-double-number-container-number">
                                                <input class="begin-range" type="number" name="filters[evaluationCriterions][<?php echo $evaluationCriterion["evaluation_criterion_id"]; ?>][minEvaluation]" step="0.1" min="1" value="1" max="5">
                                            </div>
                                            <div class="multi-range-double-number-container-number">
                                                <input class="end-range" type="number" name="filters[evaluationCriterions][<?php echo $evaluationCriterion["evaluation_criterion_id"]; ?>][maxEvaluation]" step="0.1" min="1" value="5" max="5">
                                            </div>
                                        </div>
                                        <div class="multi-range-slider-container">
                                            <div id="multi-range-slider-evaluation" class="multi-range-slider">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="filter">
                            <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                <div class="filter-title"><i class="fas fa-chevron-up"></i><span>Производители</span></div>
                            </div>
                            <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                <ul>
                                    <?php foreach (QueryExecutor::getInstance()->getManufacturersProducts($_GET["categorySubcategoryId"]) as $manufacturer): ?>
                                        <li><input type="checkbox" name="filters[manufacturers][]" value="<?php echo $manufacturer["manufacturer_id"]; ?>" onclick="onCheckedChanged(this, <?php echo $_GET["categorySubcategoryId"]; ?>);"><span><?php echo "{$manufacturer["manufacturer_name"]}"; ?><span class="counter-manufacturer-value"><?php echo "(" . QueryExecutor::getInstance()->getCountOfProductsWithAGivenManufacturer($manufacturer["manufacturer_id"], implode(", ", $_SESSION["values"]))["count_of_products"] . ")"; ?></span></span></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php foreach (QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory(null, null, null, null, $_GET["categorySubcategoryId"], null, true, false, "") as $characteristic): ?>
                            <?php if(count(QueryExecutor::getInstance()->getCharacteristicQuantityUnitValues($characteristic["characteristic_id"], null, null, "")) > 0): ?>
                                <div class="filter">
                                    <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                        <div class="filter-title"><i class="fas fa-chevron-up"></i><span><?php echo $characteristic["characteristic_name"]; ?></span></div>
                                    </div>
                                    <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                        <ul>
                                            <?php foreach (QueryExecutor::getInstance()->getUsedCharacteristicQuantityUnitValues($characteristic["characteristic_id"], $_GET["categorySubcategoryId"]) as $value): ?>
                                                <li><input type="checkbox" name="filters[characteristics][<?php echo $characteristic["characteristic_id"] ?>][]" value="<?php echo $value["id"]; ?>" onclick="onCheckedChanged(this, <?php echo $_GET["categorySubcategoryId"]; ?>);"><span><?php echo "{$value["value"]} {$value["unit_designation"]}";?><span class="counter-characteristic-quantity-unit-value"><?php echo "(" . QueryExecutor::getInstance()->getCountOfProductsWithAGivenCharacteristicQuantityUnitValue($value["id"], implode(", ", $_SESSION["values"]))["count_of_products"] . ")"; ?></span></span></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="filter-arrow-left" style="display: none;">
                            <div class="filter-arrow-left-content">
                                <div class="filter-arrow-left-content-link">
                                    <a onclick="onClickShowProductsFilterArrowLeft(<?php echo $_GET["categorySubcategoryId"]; ?>);"><span>Показать</span></a>
                                </div>
                                <div class="filter-arrow-left-content-counter-products-container">
                                    <span class="filter-arrow-left-content-counter-products"></span>
                                </div>
                                <div class="filter-arrow-left-content-action">
                                    <i class="fas fa-window-close" onclick="onClickCloseFilterArrowLeft();"></i>
                                </div>
                            </div>
                        </div>
                        <div class="reset-filters">
                            <input class="reset-filters-button" type="reset" name="action" value="Сбросить фильтры"  onclick="updateCountersFilters(<?php echo $_GET["categorySubcategoryId"]; ?>);">
                        </div>
                        <div class="apply-filters">
                            <input class="apply-filters-button" type="button" name="action" onclick="onClickApply(<?php echo $_GET["categorySubcategoryId"]; ?>);" value="Применить">
                        </div>
                    </fieldset>
                </form>
                <div class="content-products" style="width: 65%;">
                    <div id="productsBlock" class="products-block">
                        <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/ProductsBlock.php"; ?>
                    </div>
                    <div class="pagination">
                        <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php"; ?>
                    </div>
                </div>
            </div>
            <?php VisibleError::showError(); ?>
        <?php else: ?>
            <?php Access::denyAccess(); ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
<script src="/Resources/Packages/Nouislider/nouislider.min.js"></script>
<script src="/JS/MultiRange.js"></script>
</body>
</html>