<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

if(isset($_GET["action"]) && $_GET["action"] == "Категории"){
    header("Location: Categories.php?classificationId=" . $_GET["classificationId"]);
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Подкатегории"){
    header("Location: Subcategories.php?categoryId=" . $_GET["categoryId"]);
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "КатегорииПодкатегории"){
    header("Location: CategoriesSubcategory.php?subcategoryId=" . $_GET["subcategoryId"]);
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Товары"){
    header("Location: Products.php?categorySubcategoryId=" . $_GET["categorySubcategoryId"]);
    exit();
}
?>