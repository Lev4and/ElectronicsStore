<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$classifications = array();
$evaluationCriterions = array();
$evaluationCriterionsCategorySubcategory = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddEvaluationCriterionCategorySubcategory.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditEvaluationCriterionCategorySubcategory.php?evaluationCriterionCategorySubcategoryId={$_POST["selectedEvaluationCriterionCategorySubcategory"]}");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeEvaluationCriterionCategorySubcategory($_POST["selectedEvaluationCriterionCategorySubcategory"]);

    header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/EvaluationCriterionCategorySubcategory/");
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
    if (isset($_POST["evaluationCriterionId"]) && $_POST["evaluationCriterionId"] > 0 && isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0) {
        if (!QueryExecutor::getInstance()->containsEvaluationCriterionCategorySubcategory($_POST["evaluationCriterionId"], $_POST["categorySubcategoryId"])) {
            QueryExecutor::getInstance()->addEvaluationCriterionCategorySubcategory($_POST["evaluationCriterionId"], $_POST["categorySubcategoryId"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/EvaluationCriterionCategorySubcategory/");
            exit();
        }
        else{
            $_SESSION["error"] = "Критерия оценивания категории подкатегорий с такими данными уже существует.";

            header("Location: AddEvaluationCriterionCategorySubcategory.php");
            exit();
        }
    }
    else {
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddEvaluationCriterionCategorySubcategory.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["evaluationCriterionId"]) && $_POST["evaluationCriterionId"] > 0 && isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0) {
        if (!QueryExecutor::getInstance()->containsEvaluationCriterionCategorySubcategory($_POST["evaluationCriterionId"], $_POST["categorySubcategoryId"])) {
            QueryExecutor::getInstance()->updateEvaluationCriterionCategorySubcategory($_GET["evaluationCriterionCategorySubcategoryId"], $_POST["evaluationCriterionId"], $_POST["categorySubcategoryId"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/EvaluationCriterionCategorySubcategory/");
            exit();
        }
        else{
            $_SESSION["error"] = "Критерия оценивания категории подкатегорий с такими данными уже существует.";

            header("Location: EditEvaluationCriterionCategorySubcategory.php?evaluationCriterionCategorySubcategoryId={$_GET["evaluationCriterionCategorySubcategoryId"]}");
            exit();
        }
    }
    else {
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditEvaluationCriterionCategorySubcategory.php?evaluationCriterionCategorySubcategoryId={$_GET["evaluationCriterionCategorySubcategoryId"]}");
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $evaluationCriterionsCategorySubcategory = QueryExecutor::getInstance()->getEvaluationCriterionsCategorySubcategory($_POST["evaluationCriterionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["inputSearch"]);

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableEvaluationCriterionsCategorySubcategory.php";
    exit();
}

if(!isset($_POST["action"])){
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $evaluationCriterions = QueryExecutor::getInstance()->getEvaluationCriterions("");
    $evaluationCriterionsCategorySubcategory = QueryExecutor::getInstance()->getEvaluationCriterionsCategorySubcategory($_POST["evaluationCriterionId"], $_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["inputSearch"]);

    include "EvaluationCriterionsCategorySubcategory.php";
}
?>