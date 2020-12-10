<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$classifications = array();
$categories = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddCategory.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditCategory.php?categoryId=" . $_POST["selectedCategory"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCategory($_POST["selectedCategory"]);

    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $categories = QueryExecutor::getInstance()->getCategories($_POST["classificationId"], $_POST["inputSearch"]);

    include "Categories.php";
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

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $categories = QueryExecutor::getInstance()->getCategories($_POST["classificationId"], $_POST["inputSearch"]);

    include "Categories.php";
}
?>