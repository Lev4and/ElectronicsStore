<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

$sections = array();
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

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCharacteristicCategorySubcategory($_POST["selectedCharacteristicCategorySubcategory"]);

    $sections = QueryExecutor::getInstance()->getSections("");
    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $characteristicsCategorySubcategory = QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory($_POST["sectionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["characteristicId"], $_POST["useWhenFiltering"], $_POST["useWhenDisplayingAsBasicInformation"], $_POST["inputSearch"]);

    include "CharacteristicsCategorySubcategory.php";
}

if(isset($_GET["action"]) && $_GET["action"] == "Предварительное применение фильтров"){
    $characteristicsCategorySubcategory = QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory($_POST["sectionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["characteristicId"], $_POST["useWhenFiltering"], $_POST["useWhenDisplayingAsBasicInformation"], $_POST["inputSearch"]);

    $_SESSION["preValues"] = array();

    foreach ($characteristicsCategorySubcategory as $characteristicCategorySubcategory){
        array_push($_SESSION["preValues"], $characteristicCategorySubcategory["id"]);
    }

    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Обновить предварительный счетчик количества записей"){
    $countValues = count($_SESSION["preValues"]);
    $word1 = NumWord::numberWord($countValues, array('Найден', 'Найдено', 'Найдены'), false);
    $word2 = NumWord::numberWord($countValues, array('запись', 'записи', 'записей'));

    echo "{$word1} {$word2}";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Обновить счетчик количества записей"){
    $countValues = count($_SESSION["values"]);
    $word = NumWord::numberWord($countValues, array('запись', 'записи', 'записей'));

    echo "{$word}";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Поменять страницу"){
    if(isset($_GET["numberPage"]) && $_GET["numberPage"] > 0){
        $characteristicsCategorySubcategory = QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory($_POST["sectionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["characteristicId"], $_POST["useWhenFiltering"], $_POST["useWhenDisplayingAsBasicInformation"], $_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCharacteristicsCategorySubcategory.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["sectionCategorySubcategoryId"]) && $_POST["sectionCategorySubcategoryId"] > 0 && isset($_POST["characteristicId"]) && $_POST["characteristicId"] > 0 && isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0) {
        if (!QueryExecutor::getInstance()->containsCharacteristicCategorySubcategory($_POST["characteristicId"], $_POST["categorySubcategoryId"])) {
            QueryExecutor::getInstance()->addCharacteristicCategorySubcategory($_POST["characteristicId"], $_POST["categorySubcategoryId"], $_POST["sectionCategorySubcategoryId"], $_POST["useWhenFiltering"], $_POST["useWhenDisplayingAsBasicInformation"]);

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
    if (isset($_POST["sectionCategorySubcategoryId"]) && $_POST["sectionCategorySubcategoryId"] > 0 && isset($_POST["characteristicId"]) && $_POST["characteristicId"] > 0 && isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0) {
        if (!QueryExecutor::getInstance()->containsCharacteristicCategorySubcategory($_POST["characteristicId"], $_POST["categorySubcategoryId"]) || ($_POST["characteristicId"] == $_GET["characteristicId"] && $_POST["categorySubcategoryId"] == $_GET["categorySubcategoryId"])) {
            QueryExecutor::getInstance()->updateCharacteristicCategorySubcategory($_GET["characteristicCategorySubcategoryId"], $_POST["characteristicId"], $_POST["categorySubcategoryId"], $_POST["sectionCategorySubcategoryId"], $_POST["useWhenFiltering"], $_POST["useWhenDisplayingAsBasicInformation"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/CharacteristicCategorySubcategory/");
            exit();
        } else {
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

if(isset($_POST["action"]) && $_POST["action"] == "РазделыХарактеристикиКатегорииПодкатегории"){
    if(isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0){
        echo '<option value="">Выберите раздел характеристики категории подкатегори</option>';
        foreach (QueryExecutor::getInstance()->getSectionsCategorySubcategory(null, null, null, null, $_POST["categorySubcategoryId"], "") as $sectionCategorySubcategory){
            echo '<option value="' .$sectionCategorySubcategory["id"] . '">' . $sectionCategorySubcategory["section_name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите раздел характеристики категории подкатегори</option>';
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $sections = QueryExecutor::getInstance()->getSections("");
    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $characteristicsCategorySubcategory = QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory($_POST["sectionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["characteristicId"], $_POST["useWhenFiltering"], $_POST["useWhenDisplayingAsBasicInformation"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($characteristicsCategorySubcategory as $characteristicCategorySubcategory){
        array_push($_SESSION["values"], $characteristicCategorySubcategory["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCharacteristicsCategorySubcategory.php";
    exit();
}

if(!isset($_POST["action"])){
    $sections = QueryExecutor::getInstance()->getSections("");
    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $characteristicsCategorySubcategory = QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory($_POST["sectionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["characteristicId"], $_POST["useWhenFiltering"], $_POST["useWhenDisplayingAsBasicInformation"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($characteristicsCategorySubcategory as $characteristicCategorySubcategory){
        array_push($_SESSION["values"], $characteristicCategorySubcategory["id"]);
    }

    include "CharacteristicsCategorySubcategory.php";
}
?>