<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$product = QueryExecutor::getInstance()->getProduct($_GET["productId"]);
$categories = QueryExecutor::getInstance()->getCategories($product["classification_id"], "");
$manufacturers = QueryExecutor::getInstance()->getManufacturers("");
$quantityUnits = QueryExecutor::getInstance()->getQuantityUnits(null, null, "");
$subcategories = QueryExecutor::getInstance()->getSubcategories(null, $product["category_id"], "");
$classifications = QueryExecutor::getInstance()->getClassifications("");
$categoriesSubcategory = QueryExecutor::getInstance()->getCategoriesSubcategory(null, null, $product["subcategory_id"], "");
$productCharacteristicsQuantityUnitValues = QueryExecutor::getInstance()->getProductCharacteristicsQuantityUnitValues($_GET["productId"]);

function containsCharacteristicsQuantityUnitValue($value){
    foreach ($GLOBALS["productCharacteristicsQuantityUnitValues"] as $key){
        if($key["characteristic_quantity_unit_value_id"] == $value){
            return true;
        }
    }

    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о товаре</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/EditProduct.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/Form.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
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
            <div class="header-block">
                <h1>Изменение данных о товаре</h1>
            </div>
            <div class="form-block">
                <form action=".?productId=<?php echo $_GET["productId"]; ?>&manufacturerId=<?php echo $product["manufacturer_id"]; ?>&model=<?php echo $product["model"]; ?>&photo=<?php echo $product["photo"]; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-block-image-block">
                        <div class="form-block-image-block-container">
                            <img id="product-photo" name="photo" src="<?php echo "http://" . $_SERVER["SERVER_NAME"] . "/Resources/Images/Upload/" . $product["photo"]; ?>">
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
                                            <option value="<?php echo $classification["id"]; ?>" <?php echo $classification["id"] == $product["classification_id"] ? 'selected="selected"' : ""; ?>><?php echo $classification["name"]; ?></option>
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
                                        <option value="">Выберите категорию</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category["id"]; ?>" <?php echo $category["id"] == $product["category_id"] ? 'selected="selected"' : ""; ?>><?php echo $category["name"]; ?></option>
                                        <?php endforeach; ?>
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
                                        <option value="">Выберите подкатегорию</option>
                                        <?php foreach ($subcategories as $subcategory): ?>
                                            <option value="<?php echo $subcategory["id"]; ?>" <?php echo $subcategory["id"] == $product["subcategory_id"] ? 'selected="selected"' : ""; ?>><?php echo $subcategory["name"]; ?></option>
                                        <?php endforeach; ?>
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
                                        <option value="">Выберите категорию подкатегории</option>
                                        <?php foreach ($categoriesSubcategory as $categorySubcategory): ?>
                                            <option value="<?php echo $categorySubcategory["id"]; ?>" <?php echo $categorySubcategory["id"] == $product["category_subcategory_id"] ? 'selected="selected"' : ""; ?>><?php echo $categorySubcategory["name"]; ?></option>
                                        <?php endforeach; ?>
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
                                            <option value="<?php echo $manufacturer["id"]; ?>" <?php echo $manufacturer["id"] == $product["manufacturer_id"] ? 'selected="selected"' : ""; ?>><?php echo $manufacturer["name"]; ?></option>
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
                                    <input type="text" name="model" value="<?php echo $product["model"]; ?>">
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
                                    <input type="number" style="text-align: right" name="price" value="<?php echo $product["price"]; ?>" pattern="\d [0-9]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-block-description">
                        <fieldset class="form-block-description-fieldset">
                            <legend>Описание товара</legend>
                            <div class="form-block-description-fieldset-textarea-block">
                                <textarea name="description"><?php echo $product["description"]; ?></textarea>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-block-characteristics">
                        <fieldset class="form-block-characteristics-fieldset">
                            <legend>Характеристики</legend>
                            <div id="characteristics-block" class="form-block-description-fieldset-characteristics-block">
                                <?php foreach (QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory(null, null, null, $product["category_subcategory_id"], null, "") as $characteristic): ?>
                                    <div class="form-block-characteristic-row" style="margin: 10px 0; border-top: solid black 1px; border-bottom: solid black 1px;">
                                        <div class="form-block-row">
                                            <div id="form-block-row-column-label" class="form-block-row-column">
                                                <div class="form-block-row-column-label">
                                                    <label style="text-align: left"><input type="hidden" name="characteristics[<?php echo $characteristic["characteristic_id"];  ?>]"/><?php echo $characteristic["characteristic_name"]; ?></label>
                                                </div>
                                            </div>
                                            <div id="form-block-row-column-input" class="form-block-row-column">
                                                <div class="form-block-row-column-input-select">
                                                    <select id="characteristic-quantity-unit-values" name="characteristics[<?php echo $characteristic["characteristic_id"];  ?>][characteristicQuantityUnitValueId]">
                                                        <option value="">Выберите значение характеристики</option>
                                                        <?php foreach (QueryExecutor::getInstance()->getCharacteristicQuantityUnitValues($characteristic["characteristic_id"], null, null, "") as $value): ?>
                                                            <option value="<?php echo $value["id"]; ?>" <?php echo isset($productCharacteristicsQuantityUnitValues) && containsCharacteristicsQuantityUnitValue($value["id"]) ? 'selected="selected"' : ""; ?>><?php echo "{$value["value"]} {$value["unit_designation"]}"; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-block-row">
                                            <div id="form-block-characteristic-row-column-input-checkbox" class="form-block-row-column" style="width: 100%; max-width: 100%">
                                                <div  class="form-block-row-column-input-checkbox" style="width: 100%; height: 100%; display: flex; flex-direction: row; justify-content: center">
                                                    <div style="margin: auto">
                                                        <input type="checkbox" name="characteristics[<?php echo $characteristic["characteristic_id"];  ?>][newCharacteristicQuantityUnitValue][whetherToAdd]" style="margin: auto; max-height: 100%;">
                                                        <span style="margin: auto; max-height: 100%; text-align: left;">Новое значение</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-block-row">
                                            <div id="form-block-characteristic-row-column-input" class="form-block-row-column" style="display: flex; flex-direction: row; justify-content: flex-start">
                                                <div class="form-block-row-column-input-text" style="width: 95%">
                                                    <input type="text" name="characteristics[<?php echo $characteristic["characteristic_id"];  ?>][newCharacteristicQuantityUnitValue][value]" placeholder="Новое значение">
                                                </div>
                                            </div>
                                            <div id="form-block-row-column-input" class="form-block-row-column" style="display: flex; flex-direction: row; justify-content: flex-end">
                                                <div class="form-block-row-column-input-select" style="width: 95%">
                                                    <select name="characteristics[<?php echo $characteristic["characteristic_id"];  ?>][newCharacteristicQuantityUnitValue][quantityUnitId]">
                                                        <option value="">Выберите единицу измерения величины</option>
                                                        <?php foreach ($quantityUnits as $quantityUnit): ?>
                                                            <option value="<?php echo $quantityUnit["id"]; ?>"><?php echo $quantityUnit["quantity_name"] . " - (" . $quantityUnit["unit_name"] . " (" . $quantityUnit["unit_designation"] . "))"; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-block-actions">
                        <div class="form-block-actions-button">
                            <input class="action-button" id="add-button" type="submit" name="action" value="Сохранить"/>
                        </div>
                        <div class="form-block-actions-select-file">
                            <input id="select-file" type="file" name="selectedImage" accept="image/*" onchange="onChangeSelectedFile('select-file' , 'product-photo');">
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