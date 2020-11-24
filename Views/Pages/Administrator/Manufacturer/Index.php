<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

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

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsManufacturer($_POST["name"])) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->addManufacturer($_POST["name"], $fileName);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Manufacturer/");
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
        if (!QueryExecutor::getInstance()->containsManufacturer($_POST["name"]) || $_GET["flag"] != $_FILES["selectedImage"]["tmp_name"]) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->updateManufacturer($_GET["manufacturerId"], $_POST["name"], iconv_strlen($fileName) > 0 ? $fileName : $_GET["flag"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Manufacturer/");
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

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $manufacturers = QueryExecutor::getInstance()->getManufacturers($_POST["inputSearch"]);

    include "Manufacturers.php";
}
?>