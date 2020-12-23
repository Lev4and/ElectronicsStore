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
    <title>ElectronicsStore - Характеристики категории подкатегории</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/CharacteristicsCategorySubcategory.css">
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
    <script src="/JS/CharacteristicsCategorySubcategory.js"></script>
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
                <h1>Характеристики категории подкатегории</h1>
            </div>
            <form id="filtersForm" action="." method="post">
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Toolbar.php"; ?>
                <div style="width: 100%; display: flex; flex-direction: row; justify-content: space-between;">
                    <fieldset class="filters-block">
                        <legend>Фильтры</legend>
                        <div class="filter">
                            <span>Разделы</span>
                            <div>
                                <select id="select-sections" name="sectionId">
                                    <option value="">Выберите раздел</option>
                                    <?php foreach ($sections as $section): ?>
                                        <option value="<?php echo $section["id"]; ?>"><?php echo $section["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
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
                            <span>Характеристики</span>
                            <div>
                                <select id="select-characteristics" name="characteristicId">
                                    <option value="">Выберите характеристику</option>
                                    <?php foreach ($characteristics as $characteristic): ?>
                                        <option value="<?php echo $characteristic["id"]; ?>"><?php echo $characteristic["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter">
                            <span>Используется при фильтрации?</span>
                            <div>
                                <select id="select-use-when-filtering" name="useWhenFiltering">
                                    <option value="">Не имеет значения</option>
                                    <option value="0">Нет</option>
                                    <option value="1">Да</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter">
                            <span>Используется как основная информация?</span>
                            <div>
                                <select id="use-when-displaying-as-basic-information" name="useWhenDisplayingAsBasicInformation">
                                    <option value="">Не имеет значения</option>
                                    <option value="0">Нет</option>
                                    <option value="1">Да</option>
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
                        <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCharacteristicsCategorySubcategory.php"; ?>
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