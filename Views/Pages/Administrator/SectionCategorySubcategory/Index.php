<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

$sections = array();
$sectionsCategorySubcategory = array();
$classifications = QueryExecutor::getInstance()->getClassifications("");

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddSectionCategorySubcategory.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditSectionCategorySubcategory.php?sectionCategorySubcategoryId=" . $_POST["selectedSectionCategorySubcategory"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeSectionCategorySubcategory($_POST["selectedSectionCategorySubcategory"]);

    header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/SectionCategorySubcategory/");
    exit();
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

if(isset($_GET["action"]) && $_GET["action"] == "Предварительное применение фильтров"){
    $sectionsCategorySubcategory = QueryExecutor::getInstance()->getSectionsCategorySubcategory($_POST["sectionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"],  $_POST["inputSearch"]);

    $_SESSION["preValues"] = array();

    foreach ($sectionsCategorySubcategory as $sectionCategorySubcategory){
        array_push($_SESSION["preValues"], $sectionCategorySubcategory["id"]);
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
        $sectionsCategorySubcategory = QueryExecutor::getInstance()->getSectionsCategorySubcategory($_POST["sectionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"],  $_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableSectionsCategorySubcategory.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["sectionId"]) && $_POST["sectionId"] > 0 && isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0) {
        if (!QueryExecutor::getInstance()->containsSectionCategorySubcategory($_POST["sectionId"], $_POST["categorySubcategoryId"])) {
            QueryExecutor::getInstance()->addSectionCategorySubcategory($_POST["sectionId"], $_POST["categorySubcategoryId"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/SectionCategorySubcategory/");
            exit();
        }
        else{
            $_SESSION["error"] = "Раздел характеристики категории подкатегорий с такими данными уже существует.";

            header("Location: AddSectionCategorySubcategory.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddSectionCategorySubcategory.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["sectionId"]) && $_POST["sectionId"] > 0 && isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0) {
        if (!QueryExecutor::getInstance()->containsSectionCategorySubcategory($_POST["sectionId"], $_POST["categorySubcategoryId"])) {
            QueryExecutor::getInstance()->updateSectionCategorySubcategory($_GET["sectionCategorySubcategoryId"], $_POST["sectionId"], $_POST["categorySubcategoryId"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/SectionCategorySubcategory/");
            exit();
        }
        else{
            $_SESSION["error"] = "Раздел характеристики категории подкатегорий с такими данными уже существует.";

            header("Location: EditSectionCategorySubcategory.php?sectionCategorySubcategoryId=" . $_GET["sectionCategorySubcategoryId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditSectionCategorySubcategory.php?sectionCategorySubcategoryId=" . $_GET["sectionCategorySubcategoryId"]);
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $sectionsCategorySubcategory = QueryExecutor::getInstance()->getSectionsCategorySubcategory($_POST["sectionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"],  $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($sectionsCategorySubcategory as $sectionCategorySubcategory){
        array_push($_SESSION["values"], $sectionCategorySubcategory["id"]);
    }


    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableSectionsCategorySubcategory.php";
    exit();
}

if(!isset($_POST["action"])){
    $sections = QueryExecutor::getInstance()->getSections("");
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $sectionsCategorySubcategory = QueryExecutor::getInstance()->getSectionsCategorySubcategory($_POST["sectionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"],  $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($sectionsCategorySubcategory as $sectionCategorySubcategory){
        array_push($_SESSION["values"], $sectionCategorySubcategory["id"]);
    }

    include "SectionsCategorySubcategory.php";
}
?>