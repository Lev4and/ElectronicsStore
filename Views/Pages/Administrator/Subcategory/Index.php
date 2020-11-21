<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$classifications = array();
$subcategories = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddSubcategory.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditSubcategory.php?subcategoryId=" . $_POST["selectedSubcategory"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeSubcategory($_POST["selectedSubcategory"]);

    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $subcategories = QueryExecutor::getInstance()->getSubcategories($_POST["classificationId"], $_POST["categoryId"], $_POST["inputSearch"]);

    include "Subcategories.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["categoryId"]) && $_POST["categoryId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsSubcategory($_POST["categoryId"], $_POST["name"])) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->addSubcategory($_POST["categoryId"], $_POST["name"], $fileName);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Subcategory/");
            exit();
        }
        else{
            $_SESSION["error"] = "Подкатегория с такими данными уже существует.";

            header("Location: AddSubcategory.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddSubcategory.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["categoryId"]) && $_POST["categoryId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsSubcategory($_POST["categoryId"], $_POST["name"])  || $_GET["photo"] != $_FILES["selectedImage"]["tmp_name"]) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->updateSubcategory($_GET["subcategoryId"], $_POST["categoryId"], $_POST["name"], iconv_strlen($fileName) > 0 ? $fileName : $_GET["photo"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Subcategory/");
            exit();
        }
        else{
            $_SESSION["error"] = "Подкатегория с такими данными уже существует.";

            header("Location: EditSubcategory.php?subcategoryId=" . $_GET["subcategoryId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditSubcategory.php?subcategoryId=" . $_GET["subcategoryId"]);
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

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $subcategories = QueryExecutor::getInstance()->getSubcategories($_POST["classificationId"], $_POST["categoryId"], $_POST["inputSearch"]);

    include "Subcategories.php";
}
?>