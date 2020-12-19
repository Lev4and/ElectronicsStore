<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$characteristicQuantityUnitValues = array();
$characteristics = array();
$quantities = array();
$units = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddCharacteristicQuantityUnitValue.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditCharacteristicQuantityUnitValue.php?characteristicQuantityUnitValueId=" . $_POST["selectedCharacteristicQuantityUnitValue"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCharacteristicQuantityUnitValue($_POST["selectedCharacteristicQuantityUnitValue"]);

    $characteristicQuantityUnitValues = QueryExecutor::getInstance()->getCharacteristicQuantityUnitValues($_POST["characteristicId"], $_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);
    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $quantities = QueryExecutor::getInstance()->getQuantities("");
    $units = QueryExecutor::getInstance()->getUnits("");

    include "CharacteristicQuantityUnitValues.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["characteristicId"]) && $_POST["characteristicId"] > 0 && isset($_POST["quantityUnitId"]) && $_POST["quantityUnitId"] > 0 && iconv_strlen($_POST["value"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsCharacteristicQuantityUnitValue($_POST["characteristicId"], $_POST["quantityUnitId"], $_POST["value"])) {
            QueryExecutor::getInstance()->addCharacteristicQuantityUnitValue($_POST["characteristicId"], $_POST["quantityUnitId"], $_POST["value"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/CharacteristicQuantityUnitValue/");
            exit();
        }
        else{
            $_SESSION["error"] = "Значение характеристики с такими данными уже существует.";

            header("Location: AddCharacteristicQuantityUnitValue.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddCharacteristicQuantityUnitValue.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["characteristicId"]) && $_POST["characteristicId"] > 0 && isset($_POST["quantityUnitId"]) && $_POST["quantityUnitId"] > 0 && iconv_strlen($_POST["value"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsCharacteristicQuantityUnitValue($_POST["characteristicId"], $_POST["quantityUnitId"], $_POST["value"])) {
            QueryExecutor::getInstance()->updateCharacteristicQuantityUnitValue($_GET["characteristicQuantityUnitValueId"], $_POST["characteristicId"], $_POST["quantityUnitId"], $_POST["value"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/CharacteristicQuantityUnitValue/");
            exit();
        }
        else{
            $_SESSION["error"] = "Значение характеристики с такими данными уже существует.";

            header("Location: EditCharacteristicQuantityUnitValue.php?characteristicQuantityUnitValueId=" . $_GET["characteristicQuantityUnitValueId"]);
            exit();
        }
    }
    else {
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditCharacteristicQuantityUnitValue.php?characteristicQuantityUnitValueId=" . $_GET["characteristicQuantityUnitValueId"]);
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $characteristicQuantityUnitValues = QueryExecutor::getInstance()->getCharacteristicQuantityUnitValues($_POST["characteristicId"], $_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);
    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $quantities = QueryExecutor::getInstance()->getQuantities("");
    $units = QueryExecutor::getInstance()->getUnits("");

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCharacteristicQuantityUnitValues.php";
    exit();
}

if(!isset($_POST["action"])){
    $characteristicQuantityUnitValues = QueryExecutor::getInstance()->getCharacteristicQuantityUnitValues($_POST["characteristicId"], $_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);
    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $quantities = QueryExecutor::getInstance()->getQuantities("");
    $units = QueryExecutor::getInstance()->getUnits("");

    include "CharacteristicQuantityUnitValues.php";
}
?>