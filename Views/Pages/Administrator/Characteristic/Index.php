<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$characteristics = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddCharacteristic.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditCharacteristic.php?characteristicId=" . $_POST["selectedCharacteristic"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCharacteristic($_POST["selectedCharacteristic"]);

    $characteristics = QueryExecutor::getInstance()->getCharacteristics($_POST["inputSearch"]);

    include "Characteristics.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsCharacteristic($_POST["name"])) {
            QueryExecutor::getInstance()->addCharacteristic($_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/Characteristic/");
            exit();
        }
        else{
            $_SESSION["error"] = "Характеристика с такими данными уже существует.";

            header("Location: AddCharacteristic.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddCharacteristic.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsCharacteristic($_POST["name"])) {
            QueryExecutor::getInstance()->updateCharacteristic($_GET["characteristicId"], $_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Characteristic/");
            exit();
        }
        else{
            $_SESSION["error"] = "Характеристика с такими данными уже существует.";

            header("Location: EditCharacteristic.php?characteristicId=" . $_GET["characteristicId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditCharacteristic.php?characteristicId=" . $_GET["characteristicId"]);
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $characteristics = QueryExecutor::getInstance()->getCharacteristics($_POST["inputSearch"]);

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCharacteristics.php";
    exit();
}

if(!isset($_POST["action"])){
    $characteristics = QueryExecutor::getInstance()->getCharacteristics($_POST["inputSearch"]);

    include "Characteristics.php";
}
?>