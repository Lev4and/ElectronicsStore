<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

if(!isset($_COOKIE["viewedProducts"])){
    $_COOKIE["viewedProducts"] = "";
}

if(!isset($_COOKIE["purchasedProducts"])){
    $_COOKIE["purchasedProducts"] = "";
}

if(!isset($_COOKIE["favoriteProducts"])){
    $_COOKIE["favoriteProducts"] = "";
}

if(!isset($_SESSION["oldListPreProducts"])){
    $_SESSION["oldListPreProducts"] = array();
}

if(!isset($_SESSION["preProducts"])){
    $_SESSION["preProducts"] = array();
}

if(!isset($_SESSION["pageNumber"])){
    $_SESSION["pageNumber"] = 1;
}

$_SESSION["pageNumber"] = 2;

if(!isset($_SESSION["preValues"])){
    $_SESSION["preValues"] = array();
}

if(!isset($_SESSION["products"])){
    $_SESSION["products"] = array();
}

if(!isset($_SESSION["values"])){
    $_SESSION["values"] = array();
}

if(!isset($_SESSION["basket"])){
    $_SESSION["basket"] = array();
}

if(!isset($_SESSION["user"])){
    $_SESSION["user"] = array();
}

if(!isset($_SESSION["error"])){
    $_SESSION["error"] = "";
}

if(isset($_SESSION["error"]) && iconv_strlen($_SESSION["error"], "UTF-8") > 0){
    $_SESSION["error"] = "";
}

if(isset($_POST["action"]) && $_POST["action"] == "Поиск"){
    if(isset($_POST["textSearch"]) && iconv_strlen($_POST["textSearch"], "UTF-8") > 0){
        $categories = QueryExecutor::getInstance()->getCategories(null, $_POST["textSearch"]);
        $subcategories = QueryExecutor::getInstance()->getSubcategories(null, null, $_POST["textSearch"]);
        $classifications = QueryExecutor::getInstance()->getClassifications($_POST["textSearch"]);
        $categoriesSubcategory = QueryExecutor::getInstance()->getCategoriesSubcategory(null, null, null, $_POST["textSearch"]);

        $products = QueryExecutor::getInstance()->getProducts(null, null, null, null, null, null, null, "", $_POST["textSearch"]);
        $manufacturers = QueryExecutor::getInstance()->getManufacturers($_POST["textSearch"]);

        $result = "";
        $result .= '<ul class="container-search-result-block">';

        foreach ($classifications as $key => $classification){
            if($key < 2){
                $result .= "<li class='search-result-item' onmousemove='onMouseMoveSearchResultItem(this);' onmouseleave='onMouseLeaveSearchResultItem(this);'><a href='http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Категории&classificationId={$classification["id"]}' title='{$classification["name"]}'><span>{$classification["name"]} - Классификация</span></a></li>";
            }
            else{
                break;
            }
        }

        foreach ($categories as $key => $category){
            if($key < 2){
                $result .= "<li class='search-result-item' onmousemove='onMouseMoveSearchResultItem(this);' onmouseleave='onMouseLeaveSearchResultItem(this);'><a href='http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Подкатегории&categoryId={$category["id"]}' title='{$category["name"]}'><span>{$category["name"]} - Категория</span></a></li>";
            }
            else{
                break;
            }
        }

        foreach ($subcategories as $key => $subcategory){
            if($key < 2){
                $result .= "<li class='search-result-item' onmousemove='onMouseMoveSearchResultItem(this);' onmouseleave='onMouseLeaveSearchResultItem(this);'><a href='http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=КатегорииПодкатегории&subcategoryId={$subcategory["id"]}' title='{$subcategory["name"]}'><span>{$subcategory["name"]} - Подкатегория</span></a></li>";
            }
            else{
                break;
            }
        }

        foreach ($categoriesSubcategory as $key => $categorySubcategory){
            if($key < 2){
                $result .= "<li class='search-result-item' onmousemove='onMouseMoveSearchResultItem(this);' onmouseleave='onMouseLeaveSearchResultItem(this);'><a href='http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Товары&categorySubcategoryId={$categorySubcategory["id"]}' title='{$categorySubcategory["name"]}'><span>{$categorySubcategory["name"]} - Категория подкатегории</span></a></li>";
            }
            else{
                break;
            }
        }

        foreach ($manufacturers as $key => $manufacturer){
            if($key < 2){
                $result .= "<li class='search-result-item' onmousemove='onMouseMoveSearchResultItem(this);' onmouseleave='onMouseLeaveSearchResultItem(this);'><a href='http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/ProductsManufacturer.php?manufacturerId={$manufacturer["id"]}' title='{$manufacturer["name"]}'><span>{$manufacturer["name"]} - Производитель</span></a></li>";
            }
            else{
                break;
            }
        }

        foreach ($products as $key => $product){
            if($key < 6){
                $result .= "<li class='search-result-item' onmousemove='onMouseMoveSearchResultItem(this);' onmouseleave='onMouseLeaveSearchResultItem(this);'><a href='http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/Product.php?productId={$product["id"]}' title='{$product["manufacturer_name"]} {$product["model"]}'><span>{$product["manufacturer_name"]} {$product["model"]}</span></a></li>";
            }
            else{
                break;
            }
        }

        $result .= '</ul>';

        echo $result;
    }
    else{
        echo "";
    }

    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Авторизоваться"){
    if(QueryExecutor::getInstance()->authorization($_POST["login"], $_POST["password"])){
        $_SESSION["user"] = QueryExecutor::getInstance()->getUser($_POST["login"]);
        $_SESSION["basket"] = array();
    }
    else{
        $_SESSION["error"] = "Вы ввели неверный логин или пароль.";

        header("Location: http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Authorization.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Зарегистрироваться"){
    $roleId = $_POST["roleId"];

    $login = $_POST["login"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeatPassword"];

    if(isset($roleId) && isset($login) && iconv_strlen($login, "UTF-8") > 0 && isset($password) && iconv_strlen($password, "UTF-8") > 0 && isset($repeatPassword) && $password == $repeatPassword){
        if(!QueryExecutor::getInstance()->containsUser($login)){
            QueryExecutor::getInstance()->registration($roleId, $login, $password);

            header("Location: http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Authorization.php");
            exit();
        }
        else{
            $_SESSION["error"] = "Пользователь с таким логином уже существует.";

            header("Location: http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Registration.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Вы указали неверные данные.";

        header("Location: http://{$_SERVER["SERVER_NAME"]}}/Views/Pages/Registration.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Выход"){
    $_SESSION["user"] = array();
    $_SESSION["basket"] = array();
}

include("./Views/Pages/Main.php");
?>