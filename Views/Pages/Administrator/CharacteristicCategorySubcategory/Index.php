<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$characteristics = array();
$classifications = array();
$characteristicsCategorySubcategory = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddCharacteristicCategorySubcategory.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditCharacteristicCategorySubcategory.php?characteristicCategorySubcategoryId=" . $_POST["selectedCharacteristicCategorySubcategory"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["characteristicId"]) && $_POST["characteristicId"] > 0 && isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0) {
        if (!QueryExecutor::getInstance()->containsCharacteristicCategorySubcategory($_POST["characteristicId"], $_POST["categorySubcategoryId"])) {
            QueryExecutor::getInstance()->addCharacteristicCategorySubcategory($_POST["characteristicId"], $_POST["categorySubcategoryId"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/CharacteristicCategorySubcategory/");
            exit();
        }
        else{
            $_SESSION["error"] = "Характеристика уже присутствует в заданной категории подкатегории.";

            header("Location: AddCharacteristicCategorySubcategory.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddCharacteristicCategorySubcategory.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["characteristicId"]) && $_POST["characteristicId"] > 0 && isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0) {
        if (!QueryExecutor::getInstance()->containsCharacteristicCategorySubcategory($_POST["characteristicId"], $_POST["categorySubcategoryId"])) {
            QueryExecutor::getInstance()->updateCharacteristicCategorySubcategory($_GET["characteristicCategorySubcategoryId"], $_POST["characteristicId"], $_POST["categorySubcategoryId"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/CharacteristicCategorySubcategory/");
            exit();
        }
        else{
            $_SESSION["error"] = "Характеристика уже присутствует в заданной категории подкатегории.";

            header("Location: EditCharacteristicCategorySubcategory.php?characteristicCategorySubcategoryId=" . $_GET["characteristicCategorySubcategoryId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditCharacteristicCategorySubcategory.php?characteristicCategorySubcategoryId=" . $_GET["characteristicCategorySubcategoryId"]);
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCharacteristicCategorySubcategory($_POST["selectedCharacteristicCategorySubcategory"]);

    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $characteristicsCategorySubcategory = QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory($_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["characteristicId"], $_POST["inputSearch"]);

    include "CharacteristicsCategorySubcategory.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Категории"){
    if(isset($_POST["classificationId"]) && $_POST["classificationId"] > 0){
        echo '<option value="">Выберите категорию</option>';
        foreach (QueryExecutor::getInstance()->getCategories($_POST["classificationId"], "") as $category){
            echo '<option value="' .$category["id"] . '">' . $category["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите категорию</option>';
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Подкатегории"){
    if(isset($_POST["categoryId"]) && $_POST["categoryId"] > 0){
        echo '<option value="">Выберите подкатегорию</option>';
        foreach (QueryExecutor::getInstance()->getSubcategories(null, $_POST["categoryId"], "") as $subcategory){
            echo '<option value="' .$subcategory["id"] . '">' . $subcategory["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите подкатегорию</option>';
    }
}


if(isset($_POST["action"]) && $_POST["action"] == "КатегорииПодкатегории"){
    if(isset($_POST["subcategoryId"]) && $_POST["subcategoryId"] > 0){
        echo '<option value="">Выберите категорию подкатегории</option>';
        foreach (QueryExecutor::getInstance()->getCategoriesSubcategory(null, null, $_POST["subcategoryId"], "") as $categorySubcategory){
            echo '<option value="' .$categorySubcategory["id"] . '">' . $categorySubcategory["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите категорию подкатегории</option>';
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $characteristicsCategorySubcategory = QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory($_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["characteristicId"], $_POST["inputSearch"]);

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCharacteristicsCategorySubcategory.php";
    exit();
}

if(!isset($_POST["action"])){
    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $characteristicsCategorySubcategory = QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory($_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["characteristicId"], $_POST["inputSearch"]);

    include "CharacteristicsCategorySubcategory.php";
}
?>