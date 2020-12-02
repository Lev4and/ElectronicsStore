<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$characteristicCategorySubcategory = QueryExecutor::getInstance()->getCharacteristicCategorySubcategory($_GET["characteristicCategorySubcategoryId"]);

$characteristics = QueryExecutor::getInstance()->getCharacteristics("");
$classifications = QueryExecutor::getInstance()->getClassifications("");
$categories = QueryExecutor::getInstance()->getCategories($characteristicCategorySubcategory["classification_id"], "");
$subcategories = QueryExecutor::getInstance()->getSubcategories(null, $characteristicCategorySubcategory["category_id"], "");
$categoriesSubcategory = QueryExecutor::getInstance()->getCategoriesSubcategory(null, null, $characteristicCategorySubcategory["subcategory_id"], "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о характеристики категории подкатегории</title>
    <link rel="stylesheet" href="/CSS/Pages/EditCharacteristicCategorySubcategory.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
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
                <h1>Добавление характеристики категории подкатегории</h1>
            </div>
            <form action="http://electronicsstore/Views/Pages/Administrator/CharacteristicCategorySubcategory/?characteristicCategorySubcategoryId=<?php echo $_GET["characteristicCategorySubcategoryId"]; ?>" method="post">
                <div class="form-block">
                    <table class="form-block-table">
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите классификацию:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-classifications" name="classificationId" onchange="onChangeSelectedClassifications(this);">
                                        <option value="">Выберите классификацию</option>
                                        <?php foreach ($classifications as $classification): ?>
                                            <option value="<?php echo $classification["id"]; ?>" <?php echo $classification["id"] == $characteristicCategorySubcategory["classification_id"] ? 'selected="selected"' : ""; ?>><?php echo $classification["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td class="form-block-table-td-image" rowspan="4">
                                <img id="category-subcategory-photo" name="photo">
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите категорию:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-categories" name="categoryId" onchange="onChangeSelectedCategories(this);">
                                        <option value="">Выберите категорию</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category["id"]; ?>" <?php echo $category["id"] == $characteristicCategorySubcategory["category_id"] ? 'selected="selected"' : ""; ?>><?php echo $category["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите подкатегорию:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-subcategories" name="subcategoryId" onchange="onChangeSelectedSubcategories(this);">
                                        <option value="">Выберите подкатегорию</option>
                                        <?php foreach ($subcategories as $subcategory): ?>
                                            <option value="<?php echo $subcategory["id"]; ?>" <?php echo $subcategory["id"] == $characteristicCategorySubcategory["subcategory_id"] ? 'selected="selected"' : ""; ?>><?php echo $subcategory["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите категорию подкатегории:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-categories-subcategory" name="categorySubcategoryId">
                                        <option value="">Выберите категорию подкатегории</option>
                                        <?php foreach ($categoriesSubcategory as $categorySubcategory): ?>
                                            <option value="<?php echo $categorySubcategory["id"]; ?>" <?php echo $categorySubcategory["id"] == $characteristicCategorySubcategory["category_subcategory_id"] ? 'selected="selected"' : ""; ?>><?php echo $categorySubcategory["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите характеристику:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-characteristics" name="characteristicId">
                                        <option value="">Выберите характеристику</option>
                                        <?php foreach ($characteristics as $characteristic): ?>
                                            <option value="<?php echo $characteristic["id"]; ?>" <?php echo $characteristic["id"] == $characteristicCategorySubcategory["characteristic_id"] ? 'selected="selected"' : ""; ?>><?php echo $characteristic["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-button" colspan="2">
                                <input class="action-button" id="add-button" type="submit" name="action" value="Сохранить"/>
                            </td>
                        </tr>
                    </table>
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