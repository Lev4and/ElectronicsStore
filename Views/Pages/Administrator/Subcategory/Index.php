<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

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

if(isset($_GET["action"]) && $_GET["action"] == "Предварительное применение фильтров"){
    $subcategories = QueryExecutor::getInstance()->getSubcategories($_POST["classificationId"], $_POST["categoryId"], $_POST["inputSearch"]);

    $_SESSION["preValues"] = array();

    foreach ($subcategories as $subcategory){
        array_push($_SESSION["preValues"], $subcategory["id"]);
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
        $subcategories = QueryExecutor::getInstance()->getSubcategories($_POST["classificationId"], $_POST["categoryId"], $_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableSubcategories.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
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

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/Subcategory/");
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

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Subcategory/");
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

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $subcategories = QueryExecutor::getInstance()->getSubcategories($_POST["classificationId"], $_POST["categoryId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($subcategories as $subcategory){
        array_push($_SESSION["values"], $subcategory["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableSubcategories.php";
    exit();
}

if(!isset($_POST["action"])){
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $subcategories = QueryExecutor::getInstance()->getSubcategories($_POST["classificationId"], $_POST["categoryId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($subcategories as $subcategory){
        array_push($_SESSION["values"], $subcategory["id"]);
    }

    include "Subcategories.php";
}
?>