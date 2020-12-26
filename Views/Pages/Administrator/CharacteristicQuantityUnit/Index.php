<?php
session_start();

require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$units = array();
$quantities = array();
$characteristics = array();
$characteristicQuantityUnits = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddCharacteristicQuantityUnit.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditCharacteristicQuantityUnit.php?characteristicQuantityUnitId=" . $_POST["selectedCharacteristicQuantityUnit"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCharacteristicQuantityUnit($_POST["selectedCharacteristicQuantityUnit"]);

    $units = QueryExecutor::getInstance()->getUnits("");
    $quantities = QueryExecutor::getInstance()->getQuantities("");
    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $characteristicQuantityUnits = QueryExecutor::getInstance()->getCharacteristicQuantityUnits($_POST["characteristicId"], $_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);

    include "CharacteristicQuantityUnits.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["characteristicId"]) && $_POST["characteristicId"] > 0 && isset($_POST["quantityUnitId"]) && $_POST["quantityUnitId"] > 0) {
        if(!QueryExecutor::getInstance()->containsCharacteristicQuantityUnit($_POST["characteristicId"], $_POST["quantityUnitId"])){
            QueryExecutor::getInstance()->addCharacteristicQuantityUnit($_POST["characteristicId"], $_POST["quantityUnitId"]);

            header("Location: http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Administrator/CharacteristicQuantityUnit/");
            exit();
        }
        else{
            $_SESSION["error"] = "Величина и единицы измерения характеристики с такими данными уже существует.";

            header("Location: AddCharacteristicQuantityUnit.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddCharacteristicQuantityUnit.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["characteristicId"]) && $_POST["characteristicId"] > 0 && isset($_POST["quantityUnitId"]) && $_POST["quantityUnitId"] > 0) {
        if (!QueryExecutor::getInstance()->containsCharacteristicQuantityUnit($_POST["characteristicId"], $_POST["quantityUnitId"])) {
            QueryExecutor::getInstance()->updateCharacteristicQuantityUnit($_GET["characteristicQuantityUnitId"], $_POST["characteristicId"], $_POST["quantityUnitId"]);

            header("Location: http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Administrator/CharacteristicQuantityUnit/");
            exit();
        }
        else{
            $_SESSION["error"] = "Величина и единицы измерения характеристики с такими данными уже существует.";

            header("Location: EditCharacteristicQuantityUnit.php?characteristicQuantityUnitId={$_GET["characteristicQuantityUnitId"]}");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditCharacteristicQuantityUnit.php?characteristicQuantityUnitId={$_GET["characteristicQuantityUnitId"]}");
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $characteristicQuantityUnits = QueryExecutor::getInstance()->getCharacteristicQuantityUnits($_POST["characteristicId"], $_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCharacteristicQuantityUnits.php";
    exit();
}

if(!isset($_POST["action"])){
    $units = QueryExecutor::getInstance()->getUnits("");
    $quantities = QueryExecutor::getInstance()->getQuantities("");
    $characteristics = QueryExecutor::getInstance()->getCharacteristics("");
    $characteristicQuantityUnits = QueryExecutor::getInstance()->getCharacteristicQuantityUnits($_POST["characteristicId"], $_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);

    include "CharacteristicQuantityUnits.php";
}
?>