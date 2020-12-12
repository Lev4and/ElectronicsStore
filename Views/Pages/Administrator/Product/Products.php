<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$classifications = QueryExecutor::getInstance()->getClassifications("");
$manufacturers = QueryExecutor::getInstance()->getManufacturers("");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Товары</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/Products.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/Toolbar.css">
    <link rel="stylesheet" href="/CSS/Elements/Filters.css">
    <link rel="stylesheet" href="/CSS/Elements/Table.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/Products.js"></script>
</head>
<body>
<div class="main">
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Menu.php";
    ?>
    <div class="content">
        <?php if(Access::isAdministrator()): ?>
            <div class="header-block">
                <h1>Товары</h1>
            </div>
            <form action="." method="post">
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Toolbar.php"; ?>
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
                        <span>Производитель</span>
                        <div>
                            <select id="select-manufacturers" name="manufacturerId">
                                <option value="">Выберите производителя</option>
                                <?php foreach ($manufacturers as $manufacturer): ?>
                                    <option value="<?php echo $manufacturer["id"]; ?>"><?php echo $manufacturer["name"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="reset-filters">
                        <input class="reset-filters-button" type="submit" name="action" value="Сбросить фильтры">
                    </div>
                </fieldset>
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableProducts.php"; ?>
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