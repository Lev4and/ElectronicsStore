<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$categorySubcategory = QueryExecutor::getInstance()->getCategorySubcategory($_GET["categorySubcategoryId"]);

$classifications = QueryExecutor::getInstance()->getClassifications("");
$categories = QueryExecutor::getInstance()->getCategories($categorySubcategory["classification_id"], "");
$subcategories = QueryExecutor::getInstance()->getSubcategories(null, $categorySubcategory["category_id"], "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о категории подкатегории</title>
    <link rel="stylesheet" href="/CSS/Pages/EditCategorySubcategory.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/CategoriesSubcategory.js"></script>
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
                <h1>Изменение данных о категории подкатегории</h1>
            </div>
            <form action="http://electronicsstore/Views/Pages/Administrator/CategorySubcategory/?categorySubcategoryId=<?php echo $_GET["categorySubcategoryId"]; ?>&photo=<?php echo $categorySubcategory["photo"] ?>" method="post" enctype="multipart/form-data">
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
                                            <option value="<?php echo $classification["id"]; ?>" <?php echo $classification["id"] == $categorySubcategory["classification_id"] ? 'selected="selected"' : ""; ?>><?php echo $classification["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td class="form-block-table-td-image" rowspan="4">
                                <img id="category-subcategory-photo" name="photo" src="<?php echo "http://electronicsstore/Resources/Images/Upload/" . $categorySubcategory["photo"]; ?>">
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
                                            <option value="<?php echo $category["id"]; ?>" <?php echo $category["id"] == $categorySubcategory["category_id"] ? 'selected="selected"' : ""; ?>><?php echo $category["name"]; ?></option>
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
                                    <select id="select-subcategories" name="subcategoryId">
                                        <option value="">Выберите подкатегорию</option>
                                        <?php foreach ($subcategories as $subcategory): ?>
                                            <option value="<?php echo $subcategory["id"]; ?>" <?php echo $subcategory["id"] == $categorySubcategory["subcategory_id"] ? 'selected="selected"' : ""; ?>><?php echo $subcategory["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Введите название категории подкатегории:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <input type="text" name="name" value="<?php echo $categorySubcategory["name"]; ?>">
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-button" colspan="3">
                                <script src="/JS/UnloadFile.js"></script>
                                <input class="action-button" id="add-button" type="submit" name="action" value="Сохранить"/>
                                <input id="select-file" type="file" name="selectedImage" accept="image/*" onchange="onChangeSelectedFile('select-file' , 'category-subcategory-photo');">
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