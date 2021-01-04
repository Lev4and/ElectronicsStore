<?php
session_start();

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
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/BreadcrumbList.css">
    <link rel="stylesheet" href="/CSS/Elements/Toolbar.css">
    <link rel="stylesheet" href="/CSS/Elements/Filters.css">
    <link rel="stylesheet" href="/CSS/Elements/Table.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <script src="/JS/JQuery.js"></script>
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
            <div class="header-block">
                <h1>Критерии оценивания категории подкатегорий</h1>
            </div>
            <form id="filtersForm" action="." method="post">
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Toolbar.php"; ?>
                <div style="width: 100%; display: flex; flex-direction: row; justify-content: space-between;">
                    <fieldset class="filters-block">
                        <legend>Фильтры</legend>
                        <div class="filter">
                            <span>Классификации</span>
                            <div>
                                <select id="select-classifications" name="classificationId" onchange="onChangeSelectedClassifications(this);">
                                    <option value="">Выберите классификацию</option>
                                    <?php foreach ($classifications as $classification): ?>
                                        <option value="<?php echo $classification["id"]; ?>"><?php echo $classification["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter">
                            <span>Категории</span>
                            <div>
                                <select id="select-categories" name="categoryId" onchange="onChangeSelectedCategories(this);">

                                </select>
                            </div>
                        </div>
                        <div class="filter">
                            <span>Подкатегории</span>
                            <div>
                                <select id="select-subcategories" name="subcategoryId" onchange="onChangeSelectedSubcategories(this)">

                                </select>
                            </div>
                        </div>
                        <div class="filter">
                            <span>Категории подкатегории</span>
                            <div>
                                <select id="select-categories-subcategory" name="categorySubcategoryId">

                                </select>
                            </div>
                        </div>
                        <div class="filter">
                            <span>Критерия оценивания</span>
                            <div>
                                <select name="evaluationCriterionId">
                                    <option value="">Выберите критерию оценивания</option>
                                    <?php foreach ($evaluationCriterions as $evaluationCriterion): ?>
                                        <option value="<?php echo $evaluationCriterion["id"]; ?>"><?php echo $evaluationCriterion["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="reset-filters">
                            <input class="reset-filters-button" type="reset" name="action" value="Сбросить фильтры">
                        </div>
                        <div class="apply-filters">
                            <input class="apply-filters-button" type="button" onclick="onClickApply();" value="Применить">
                        </div>
                    </fieldset>
                    <div id="tableBlock">
                        <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableEvaluationCriterionsCategorySubcategory.php"; ?>
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