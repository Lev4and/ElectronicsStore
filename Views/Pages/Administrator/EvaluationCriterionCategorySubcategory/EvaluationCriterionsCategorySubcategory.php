<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Критерии оценивания категории подкатегорий</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/EvaluationCriterionsCategorySubcategory.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/Pagination.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/BreadcrumbList.css">
    <link rel="stylesheet" href="/CSS/Elements/FilterArrowLeft.css">
    <link rel="stylesheet" href="/CSS/Elements/Toolbar.css">
    <link rel="stylesheet" href="/CSS/Elements/Filters.css">
    <link rel="stylesheet" href="/CSS/Elements/Table.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/Filter.js"></script>
    <script src="/JS/Pagination.js"></script>
    <script src="/JS/EvaluationCriterionsCategorySubcategory.js"></script>
</head>
<body>
<div class="main">
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Menu.php";
    ?>
    <div class="content">
        <?php if(Access::isAdministrator()): ?>
            <div class="breadcrumb-list">
                <ul>
                    <li><a href="../../Main.php"><span>Меню администратора</span></a></li>
                </ul>
            </div>
            <div class="content-counter-values">
                <span>Критерии оценивания категории подкатегорий <span id="counter-values"><?php echo NumWord::numberWord(count($evaluationCriterionsCategorySubcategory), array('запись', 'записи', 'записей')); ?></span></span>
            </div>
            <form id="filtersForm" action="." method="post">
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Toolbar.php"; ?>
                <div style="width: 100%; display: flex; flex-direction: row; justify-content: space-between;">
                    <fieldset class="filters-block">
                        <legend>Фильтры</legend>
                        <div class="filter">
                            <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                <div class="filter-title"><i class="fas fa-chevron-up"></i><span>Классификации</span></div>
                            </div>
                            <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                <div class="filter-collapsible-content-select-container">
                                    <select id="select-classifications" name="classificationId" onchange="onChangeSelectedClassifications(this); onSelectedChanged(this);">
                                        <option value="">Выберите классификацию</option>
                                        <?php foreach ($classifications as $classification): ?>
                                            <option value="<?php echo $classification["id"]; ?>"><?php echo $classification["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter">
                            <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                <div class="filter-title"><i class="fas fa-chevron-up"></i><span>Категории</span></div>
                            </div>
                            <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                <div class="filter-collapsible-content-select-container">
                                    <select id="select-categories" name="categoryId" onchange="onChangeSelectedCategories(this); onSelectedChanged(this);">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter">
                            <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                <div class="filter-title"><i class="fas fa-chevron-up"></i><span>Подкатегории</span></div>
                            </div>
                            <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                <div class="filter-collapsible-content-select-container">
                                    <select id="select-subcategories" name="subcategoryId" onchange="onChangeSelectedSubcategories(this); onSelectedChanged(this);">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter">
                            <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                <div class="filter-title"><i class="fas fa-chevron-up"></i><span>Категории подкатегории</span></div>
                            </div>
                            <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                <div class="filter-collapsible-content-select-container">
                                    <select id="select-categories-subcategory" name="categorySubcategoryId" onchange="onSelectedChanged(this);">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter">
                            <div class="filter-collapsible-block" onclick="onClickOpenCollapsibleBlock(this);">
                                <div class="filter-title"><i class="fas fa-chevron-up"></i><span>Критерия оценивания</span></div>
                            </div>
                            <div id="filter-collapsible-content-collapsible" class="filter-collapsible-content">
                                <div class="filter-collapsible-content-select-container">
                                    <select name="evaluationCriterionId" onchange="onSelectedChanged(this);">
                                        <option value="">Выберите критерию оценивания</option>
                                        <?php foreach ($evaluationCriterions as $evaluationCriterion): ?>
                                            <option value="<?php echo $evaluationCriterion["id"]; ?>"><?php echo $evaluationCriterion["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-arrow-left" style="display: none;">
                            <div class="filter-arrow-left-content">
                                <div class="filter-arrow-left-content-link">
                                    <a onclick="onClickShowValuesFilterArrowLeft();"><span>Показать</span></a>
                                </div>
                                <div class="filter-arrow-left-content-counter-values-container">
                                    <span class="filter-arrow-left-content-counter-values"></span>
                                </div>
                                <div class="filter-arrow-left-content-action">
                                    <i class="fas fa-window-close" onclick="onClickCloseFilterArrowLeft();"></i>
                                </div>
                            </div>
                        </div>
                        <div class="reset-filters">
                            <input class="reset-filters-button" type="reset" name="action" value="Сбросить фильтры">
                        </div>
                        <div class="apply-filters">
                            <input class="apply-filters-button" type="button" onclick="onClickApply();" value="Применить">
                        </div>
                    </fieldset>
                    <div class="content-container" style="width: 65%;">
                        <div id="tableBlock">
                            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableEvaluationCriterionsCategorySubcategory.php"; ?>
                        </div>
                        <div class="pagination">
                            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php"; ?>
                        </div>
                    </div>
                </div>
            </form>
            <?php VisibleError::showError(); ?>
        <?php else: ?>
            <?php Access::denyAccess(); ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>