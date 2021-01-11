<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

$classifications = array();
$categories = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddCategory.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditCategory.php?categoryId={$_POST["selectedCategory"]}");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCategory($_POST["selectedCategory"]);

    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $categories = QueryExecutor::getInstance()->getCategories($_POST["classificationId"], $_POST["inputSearch"]);

    include "Categories.php";
}

if(isset($_GET["action"]) && $_GET["action"] == "Предварительное применение фильтров"){
    $categories = QueryExecutor::getInstance()->getCategories($_POST["classificationId"], $_POST["inputSearch"]);

    $_SESSION["preValues"] = array();

    foreach ($categories as $category){
        array_push($_SESSION["preValues"], $category["id"]);
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
        $categories = QueryExecutor::getInstance()->getCategories($_POST["classificationId"], $_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCategories.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["classificationId"]) && $_POST["classificationId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsCategory($_POST["classificationId"], $_POST["name"])) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->addCategory($_POST["classificationId"], $_POST["name"], $fileName);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/Category/");
            exit();
        }
        else{
            $_SESSION["error"] = "Категория с такими данными уже существует.";

            header("Location: AddCategory.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddCategory.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["classificationId"]) && $_POST["classificationId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsCategory($_POST["classificationId"], $_POST["name"]) || $_GET["photo"] != $_FILES["selectedImage"]["tmp_name"]) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->updateCategory($_GET["categoryId"], $_POST["classificationId"], $_POST["name"], iconv_strlen($fileName) > 0 ? $fileName : $_GET["photo"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/Category/");
            exit();
        }
        else{
            $_SESSION["error"] = "Категория с такими данными уже существует.";

            header("Location: EditCategory.php?categoryId=" . $_GET["categoryId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditCategory.php?categoryId=" . $_GET["categoryId"]);
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $categories = QueryExecutor::getInstance()->getCategories($_POST["classificationId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($categories as $category){
        array_push($_SESSION["values"], $category["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCategories.php";
    exit();
}

if(!isset($_POST["action"])){
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $categories = QueryExecutor::getInstance()->getCategories($_POST["classificationId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($categories as $category){
        array_push($_SESSION["values"], $category["id"]);
    }

    include "Categories.php";
}
?>