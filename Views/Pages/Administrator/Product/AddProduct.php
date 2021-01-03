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
    <title>ElectronicsStore - Добавление товара</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/AddProduct.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/BreadcrumbList.css">
    <link rel="stylesheet" href="/CSS/Elements/Form.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <link rel="stylesheet" href="/Resources/Packages/Slick/slick/slick.css"/>
    <link rel="stylesheet" href="/Resources/Packages/Slick/slick/slick-theme.css"/>
    <link rel="stylesheet" href="/CSS/Elements/Slider.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/Products.js"></script>
    <script src="/JS/UnloadFile.js"></script>
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
                    <li><a href="../../Main.php"><span>Меню администратора > </span></a></li>
                    <li><a href="../Product/"><span>Сущность БД: Товары</span></a></li>
                </ul>
            </div>
            <div class="header-block">
                <h1>Добавление товара</h1>
            </div>
            <div class="form-block">
                <form action="." method="post" enctype="multipart/form-data">
                    <div class="form-block-image-block">
                        <div class="form-block-image-block-container">
                            <img id="product-photo" name="photo">
                        </div>
                    </div>
                    <div class="form-block-inputs">
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите классификацию:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select id="select-classifications" name="classificationId" onchange="onChangeSelectedClassifications(this);">
                                        <option value="">Выберите классификацию</option>
                                        <?php foreach ($classifications as $classification): ?>
                                            <option value="<?php echo $classification["id"]; ?>"><?php echo $classification["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите категорию:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select id="select-categories" name="categoryId" onchange="onChangeSelectedCategories(this);">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите подкатегорию:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select id="select-subcategories" name="subcategoryId" onchange="onChangeSelectedSubcategories(this);">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите категорию подкатегории:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select id="select-categories-subcategory" name="categorySubcategoryId" onchange="onChangeSelectedCategoriesSubcategory(this);">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите производителя:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select id="select-manufacturers" name="manufacturerId">
                                        <option value="">Выберите производителя</option>
                                        <?php foreach ($manufacturers as $manufacturer): ?>
                                            <option value="<?php echo $manufacturer["id"]; ?>"><?php echo $manufacturer["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Введите название модели товара:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-text">
                                    <input type="text" name="model" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Введите стоимость товара:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-number">
                                    <input type="number" style="text-align: right" name="price" value="0" pattern="\d [0-9]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-block-description">
                        <fieldset class="form-block-description-fieldset">
                            <legend>Описание товара</legend>
                            <div class="form-block-description-fieldset-textarea-block">
                                <textarea name="description"></textarea>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-block-characteristics">
                        <fieldset class="form-block-characteristics-fieldset">
                            <legend>Характеристики</legend>
                            <div id="characteristics-block" class="form-block-description-fieldset-characteristics-block">

                            </div>
                        </fieldset>
                    </div>
                    <div class="form-block-actions">
                        <div class="form-block-actions-button">
                            <input class="action-button" id="add-button" type="submit" name="action" value="Записать"/>
                        </div>
                        <div class="form-block-actions-select-file">
                            <input id="select-file" type="file" name="selectedImage" accept="image/*" onchange="onChangeSelectedFile('select-file' , 'product-photo');">
                        </div>
                        <div class="form-block-actions-select-file">
                            <input id="select-files" type="file" name="selectedImages[]" accept="image/*" multiple="multiple">
                        </div>
                    </div>
                </form>
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