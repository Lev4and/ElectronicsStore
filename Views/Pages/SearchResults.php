<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

if(isset($_GET["inputSearch"]) && iconv_strlen($_GET["inputSearch"], "UTF-8") > 0){
    $categories = QueryExecutor::getInstance()->getCategories(null, $_GET["inputSearch"]);
    $subcategories = QueryExecutor::getInstance()->getSubcategories(null, null, $_GET["inputSearch"]);
    $classifications = QueryExecutor::getInstance()->getClassifications($_GET["inputSearch"]);
    $categoriesSubcategory = QueryExecutor::getInstance()->getCategoriesSubcategory(null, null, null, $_GET["inputSearch"]);

    $products = QueryExecutor::getInstance()->getProducts(null, null, null, null, null, null, null, "", $_GET["inputSearch"]);
    $manufacturers = QueryExecutor::getInstance()->getManufacturers($_GET["inputSearch"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Результат поиска</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/SearchResults.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
</head>
<body>
<div class="main">
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Menu.php";
    ?>
    <div class="content">
        <div class="header-block">
            <h1>Результат поиска</h1>
        </div>
        <div class="results-block">
            <ul>
                <?php if((isset($classifications) && count($classifications) > 0) || (isset($categories) && count($categories) > 0) || (isset($subcategories) && count($subcategories) > 0) || (isset($categoriesSubcategory) && count($categoriesSubcategory) > 0) || (isset($manufacturers) && count($manufacturers) > 0) || (isset($products) && count($products) > 0)): ?>
                    <?php if(isset($classifications) && count($classifications) > 0): ?>
                        <li><span class="results-block-title-section">Классификации</span></li>
                        <ul>
                            <?php foreach ($classifications as $classification): ?>
                                <li><span><a href="Customer/Catalog/?action=Категории&classificationId=<?php echo $classification["id"]; ?>">Классификация: <?php echo $classification["name"]; ?></a></span></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if(isset($categories) && count($categories) > 0): ?>
                        <li><span class="results-block-title-section">Категории</span></li>
                        <ul>
                            <?php foreach ($categories as $category): ?>
                                <li><span><a href="Customer/Catalog/?action=Подкатегории&categoryId=<?php echo $category["id"]; ?>">Категория: <?php echo $category["name"]; ?></a></span></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if(isset($subcategories) && count($subcategories) > 0): ?>
                        <li><span class="results-block-title-section">Подкатегории</span></li>
                        <ul>
                            <?php foreach ($subcategories as $subcategory): ?>
                                <li><span><a href="Customer/Catalog/?action=КатегорииПодкатегории&subcategoryId=<?php echo $subcategory["id"]; ?>">Подкатегория: <?php echo $subcategory["name"]; ?></a></span></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if(isset($categoriesSubcategory) && count($categoriesSubcategory) > 0): ?>
                        <li><span class="results-block-title-section">Категории подкатегории</span></li>
                        <ul>
                            <?php foreach ($categoriesSubcategory as $categorySubcategory): ?>
                                <li><span><a href="Customer/Catalog/?action=Товары&categorySubcategoryId=<?php echo $categorySubcategory["id"]; ?>">Категория подкатегории: <?php echo $categorySubcategory["name"]; ?></a></span></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if(isset($manufacturers) && count($manufacturers) > 0): ?>
                        <li><span class="results-block-title-section">Производители</span></li>
                        <ul>
                            <?php foreach ($manufacturers as $manufacturer): ?>
                                <li><span><a href="Customer/Catalog/ProductsManufacturer.php?manufacturerId=<?php echo $manufacturer["id"]; ?>">Производитель: <?php echo $manufacturer["name"]; ?></a></span></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if(isset($products) && count($products) > 0): ?>
                        <li><span class="results-block-title-section">Товары</span></li>
                        <ul>
                            <?php foreach ($products as $product): ?>
                                <li><span><a href="Customer/Catalog/Product.php?productId=<?php echo $product["id"]; ?>">Товар: <?php echo "{$product["category_subcategory_name"]} {$product["manufacturer_name"]} {$product["model"]}"; ?></a></span></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                <?php else: ?>
                    <li><span class="results-block-title-section">Результаты не найдены</span></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>