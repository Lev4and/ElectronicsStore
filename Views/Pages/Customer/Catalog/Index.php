<?php
session_start();

require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$products = array();

if(isset($_GET["action"]) && $_GET["action"] == "Каталог"){
    header("Location: Catalog.php");
    exit();
}

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
    $categorySubcategoryId = $_GET["categorySubcategoryId"];
    $products = QueryExecutor::getInstance()->getProducts(null, null, null, $categorySubcategoryId, null, null, null, "", null, null);

    include "Products.php";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Рассчитать стоимость"){
    $price = 0;

    if(isset($_POST["basket"])){
        foreach ($_POST["basket"] as $key => $value){
            $price += $value["number"] * $value["price"];
        }
    }

    echo $price;
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    $basket = array();

    foreach ($_SESSION["basket"] as $key => $value){
        if($value["productId"] != $_POST["selectedProduct"]){
            array_push($basket, $value);
        }
    }

    $_SESSION["basket"] = array();
    $_SESSION["basket"] = $basket;

    header("Location: Basket.php");
    exit();
}


if(isset($_POST["action"]) && $_POST["action"] == "Очистить"){
    $_SESSION["basket"] = array();

    header("Location: Basket.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Оформить"){
    $purchaseId = QueryExecutor::getInstance()->addPurchase($_SESSION["user"]["id"]);
    QueryExecutor::getInstance()->addPurchaseContent($purchaseId, $_POST["basket"]);

    $_SESSION["basket"] = array();

    header("Location: http://{$_SERVER["SERVER_NAME"]}/");
    exit();
}

if(!isset($_POST["action"]) || $_POST["action"] == "Применить"){
    $categorySubcategoryId = $_POST["categorySubcategoryId"];
    $products = QueryExecutor::getInstance()->getProducts(null, null, null, $categorySubcategoryId, null, $_POST["filters"]["minPrice"], $_POST["filters"]["maxPrice"], "", null, $_POST["filters"]["characteristics"], $_POST["filters"]["manufacturers"], $_POST["filters"]["minEvaluation"], $_POST["filters"]["maxEvaluation"]);

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/ProductsBlock.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "В корзину"){
    if(!in_array($_POST["productId"], $_SESSION["basket"])){
        array_push($_SESSION["basket"], array("productId" => $_POST["productId"]));
    }

    echo count($_SESSION["basket"]);
}
?>