<?php
session_start();

require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

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
    $products = QueryExecutor::getInstance()->getProducts(null, null, null, $categorySubcategoryId, null, null, null, "", null, null, null, null, null, null, null);

    $_SESSION["pageNumber"] = 1;
    $_SESSION["values"] = array();

    foreach ($products as $product){
        array_push($_SESSION["values"], $product["id"]);
    }

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

if(isset($_GET["action"]) && $_GET["action"] == "Предварительное применение фильтров"){
    $categorySubcategoryId = $_GET["categorySubcategoryId"];
    $products = QueryExecutor::getInstance()->getProducts(null, null, null, $categorySubcategoryId, null, $_POST["filters"]["minPrice"], $_POST["filters"]["maxPrice"], "", null, $_POST["filters"]["characteristics"], $_POST["filters"]["manufacturers"], $_POST["filters"]["minEvaluation"], $_POST["filters"]["maxEvaluation"], $_POST["sortMode"], $_POST["groupMode"]);

    $_SESSION["oldListPreProducts"] = $_SESSION["preProducts"];
    $_SESSION["preProducts"] = array();

    foreach ($products as $product){
        array_push($_SESSION["preProducts"], $product["id"]);
    }

    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Обновить предварительный счетчик количества продуктов"){
    $countProducts = count($_SESSION["preProducts"]);
    $word1 = NumWord::numberWord($countProducts, array('Найден', 'Найдено', 'Найдены'), false);
    $word2 = NumWord::numberWord($countProducts, array('товар', 'товара', 'товаров'));

    echo "{$word1} {$word2}";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Обновить счетчик количества продуктов"){
    $countProducts = count($_SESSION["values"]);
    $word = NumWord::numberWord($countProducts, array('товар', 'товара', 'товаров'));

    echo "{$word}";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Поменять страницу"){
    if(isset($_GET["numberPage"]) && $_GET["numberPage"] > 0){
        $categorySubcategoryId = $_GET["categorySubcategoryId"];
        $products = QueryExecutor::getInstance()->getProducts(null, null, null, $categorySubcategoryId, null, $_POST["filters"]["minPrice"], $_POST["filters"]["maxPrice"], "", null, $_POST["filters"]["characteristics"], $_POST["filters"]["manufacturers"], $_POST["filters"]["minEvaluation"], $_POST["filters"]["maxEvaluation"], $_POST["sortMode"], $_POST["groupMode"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/ProductsBlock.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    $_SESSION["pageNumber"] = 1;

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Получить значение счетчика количества товаров в зависимости от производителя"){
    if(isset($_GET["mode"]) && iconv_strlen($_GET["mode"], "UTF-8") > 0){
        if($_GET["mode"] == "Содержание"){
            if(isset($_GET["manufacturerId"]) && $_GET["manufacturerId"] > 0){
                echo QueryExecutor::getInstance()->getCountOfProductsWithAGivenManufacturer($_GET["manufacturerId"], implode(", ", $_SESSION["preProducts"]))["count_of_products"];
                exit();
            }
        }

        if($_GET["mode"] == "Добавление"){
            $categorySubcategoryId = $_GET["categorySubcategoryId"];
            $products = QueryExecutor::getInstance()->getProducts(null, null, null, $categorySubcategoryId, null, $_POST["filters"]["minPrice"], $_POST["filters"]["maxPrice"], "", null, $_POST["filters"]["characteristics"], $_POST["filters"]["manufacturers"], $_POST["filters"]["minEvaluation"], $_POST["filters"]["maxEvaluation"], $_POST["sortMode"], $_POST["groupMode"]);

            if(count($products) == 0){
                echo 0;
            }
            else{
                if(count($_SESSION["preProducts"]) > count($products)){
                    echo count($products);
                }
                else{
                    if(count($_SESSION["preProducts"]) == count($products)){
                        echo QueryExecutor::getInstance()->getCountOfProductsWithAGivenManufacturer($_GET["manufacturerId"], implode(", ", $_SESSION["preProducts"]))["count_of_products"];
                    }
                    else{
                        echo count($products) - count($_SESSION["preProducts"]);
                    }
                }
            }
            exit();
        }
    }

    echo 0;
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Получить значение счетчика количества товаров в зависимости от значения характеристики"){
    if(isset($_GET["mode"]) && iconv_strlen($_GET["mode"], "UTF-8") > 0) {
        if ($_GET["mode"] == "Содержание") {
            if(isset($_GET["characteristicQuantityUnitValueId"]) && $_GET["characteristicQuantityUnitValueId"] > 0){
                echo QueryExecutor::getInstance()->getCountOfProductsWithAGivenCharacteristicQuantityUnitValue($_GET["characteristicQuantityUnitValueId"], implode(", ", $_SESSION["preProducts"]))["count_of_products"];
                exit();
            }
        }

        if($_GET["mode"] == "Добавление"){
            $categorySubcategoryId = $_GET["categorySubcategoryId"];
            $products = QueryExecutor::getInstance()->getProducts(null, null, null, $categorySubcategoryId, null, $_POST["filters"]["minPrice"], $_POST["filters"]["maxPrice"], "", null, $_POST["filters"]["characteristics"], $_POST["filters"]["manufacturers"], $_POST["filters"]["minEvaluation"], $_POST["filters"]["maxEvaluation"], $_POST["sortMode"], $_POST["groupMode"]);

            if(count($products) == 0){
                echo 0;
            }
            else{
                if(count($_SESSION["preProducts"]) > count($products)){
                    echo count($products);
                }
                else{
                    if(count($_SESSION["preProducts"]) == count($products)){
                        echo QueryExecutor::getInstance()->getCountOfProductsWithAGivenCharacteristicQuantityUnitValue($_GET["characteristicQuantityUnitValueId"], implode(", ", $_SESSION["preProducts"]))["count_of_products"];
                    }
                    else{
                        echo count($products) - count($_SESSION["preProducts"]);
                    }
                }
            }
            exit();
        }
    }

    echo 0;
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

    header("Location: http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Basket.php");
    exit();
}


if(isset($_POST["action"]) && $_POST["action"] == "Очистить"){
    $_SESSION["basket"] = array();

    header("Location: http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Basket.php");
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
    $categorySubcategoryId = $_GET["categorySubcategoryId"];
    $products = QueryExecutor::getInstance()->getProducts(null, null, null, $categorySubcategoryId, null, $_POST["filters"]["minPrice"], $_POST["filters"]["maxPrice"], "", null, $_POST["filters"]["characteristics"], $_POST["filters"]["manufacturers"], $_POST["filters"]["minEvaluation"], $_POST["filters"]["maxEvaluation"], $_POST["sortMode"], $_POST["groupMode"]);

    $_SESSION["pageNumber"] = 1;
    $_SESSION["values"] = array();

    foreach ($products as $product){
        array_push($_SESSION["values"], $product["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/ProductsBlock.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "В корзину"){
    if(!in_array($_POST["productId"], $_SESSION["basket"])){
        array_push($_SESSION["basket"], array("productId" => $_POST["productId"]));
    }

    echo count($_SESSION["basket"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Нравиться"){
    if(isset($_POST["userId"]) && $_POST["userId"] > 0){
        QueryExecutor::getInstance()->addFavoriteProduct($_POST["productId"], $_POST["userId"]);
    }
    else{
        $favoriteProducts = "";
        $favoriteProducts = $_COOKIE["favoriteProducts"];
        $favoriteProducts .= (iconv_strlen($_COOKIE["favoriteProducts"], "UTF-8") > 0 ? ", {$_POST["productId"]}" : "{$_POST["productId"]}");

        setcookie("favoriteProducts", $favoriteProducts, time() + 3600 * 24 * 365, "/");
    }

    echo QueryExecutor::getInstance()->getCountOfLikesProduct($_POST["productId"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Не нравиться"){
    if(isset($_POST["userId"]) && $_POST["userId"] > 0){
        QueryExecutor::getInstance()->removeFavoriteProduct($_POST["productId"], $_POST["userId"]);
    }
    else{
        $favoriteProducts = "";
        $newFavoriteProducts = "";
        $favoriteProducts = $_COOKIE["favoriteProducts"];

        foreach (explode(", ", $favoriteProducts) as $productId) {
            if($productId != $_POST["productId"]){
                $newFavoriteProducts .= iconv_strlen($newFavoriteProducts, "UTF-8") > 0 ? ", {$productId}" : "{$productId}";
            }
        }

        setcookie("favoriteProducts", $newFavoriteProducts, time() + 3600 * 24 * 365, "/");
    }

    echo QueryExecutor::getInstance()->getCountOfLikesProduct($_POST["productId"]);
    exit();
}
?>