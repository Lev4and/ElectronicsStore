<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

$manufacturers = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddManufacturer.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditManufacturer.php?manufacturerId=" . $_POST["selectedManufacturer"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeManufacturer($_POST["selectedManufacturer"]);

    $manufacturers = QueryExecutor::getInstance()->getManufacturers($_POST["inputSearch"]);

    include "Manufacturers.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Обновить счетчик количества записей"){
    $countValues = count($_SESSION["values"]);
    $word = NumWord::numberWord($countValues, array('запись', 'записи', 'записей'));

    echo "{$word}";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Поменять страницу"){
    if(isset($_GET["numberPage"]) && $_GET["numberPage"] > 0){
        $manufacturers = QueryExecutor::getInstance()->getManufacturers($_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableManufacturers.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsManufacturer($_POST["name"])) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->addManufacturer($_POST["name"], $fileName);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/Manufacturer/");
            exit();
        }
        else{
            $_SESSION["error"] = "Производитель с такими данными уже существует.";

            header("Location: AddManufacturer.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddManufacturer.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsManufacturer($_POST["name"]) || $_GET["photo"] != $_FILES["selectedImage"]["tmp_name"]) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->updateManufacturer($_GET["manufacturerId"], $_POST["name"], iconv_strlen($fileName) > 0 ? $fileName : $_GET["photo"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Manufacturer/");
            exit();
        }
        else{
            $_SESSION["error"] = "Производитель с такими данными уже существует.";

            header("Location: EditManufacturer.php?manufacturerId=" . $_POST["manufacturerId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditManufacturer.php?manufacturerId=" . $_POST["manufacturerId"]);
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $manufacturers = QueryExecutor::getInstance()->getManufacturers($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($manufacturers as $manufacturer){
        array_push($_SESSION["values"], $manufacturer["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableManufacturers.php";
    exit();
}

if(!isset($_POST["action"])){
    $manufacturers = QueryExecutor::getInstance()->getManufacturers($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($manufacturers as $manufacturer){
        array_push($_SESSION["values"], $manufacturer["id"]);
    }

    include "Manufacturers.php";
}
?>