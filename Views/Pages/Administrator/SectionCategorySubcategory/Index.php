<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

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

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableSectionsCategorySubcategory.php";
    exit();
}

if(!isset($_POST["action"])){
    $sections = QueryExecutor::getInstance()->getSections("");
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $sectionsCategorySubcategory = QueryExecutor::getInstance()->getSectionsCategorySubcategory($_POST["sectionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"],  $_POST["inputSearch"]);

    include "SectionsCategorySubcategory.php";
}
?>