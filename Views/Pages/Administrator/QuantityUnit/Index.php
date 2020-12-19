<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$quantityUnits = array();
$quantities = array();
$units = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddQuantityUnit.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditQuantityUnit.php?quantityUnitId=" . $_POST["selectedQuantityUnit"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeQuantityUnit($_POST["selectedQuantityUnit"]);

    $quantityUnits = QueryExecutor::getInstance()->getQuantityUnits($_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);
    $quantities = QueryExecutor::getInstance()->getQuantities("");
    $units = QueryExecutor::getInstance()->getUnits("");

    include "QuantityUnits.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["quantityId"]) && $_POST["quantityId"] > 0 && isset($_POST["unitId"]) && $_POST["unitId"] > 0) {
        if (!QueryExecutor::getInstance()->containsQuantityUnit($_POST["quantityId"], $_POST["unitId"])) {
            QueryExecutor::getInstance()->addQuantityUnit($_POST["quantityId"], $_POST["unitId"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/QuantityUnit/");
            exit();
        }
        else{
            $_SESSION["error"] = "Единица измерения величины с такими данными уже существует.";

            header("Location: AddQuantityUnit.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddQuantityUnit.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["quantityId"]) && $_POST["quantityId"] > 0 && isset($_POST["unitId"]) && $_POST["unitId"] > 0) {
        if (!QueryExecutor::getInstance()->containsQuantityUnit($_POST["quantityId"], $_POST["unitId"])) {
            QueryExecutor::getInstance()->updateQuantityUnit($_GET["quantityUnitId"], $_POST["quantityId"], $_POST["unitId"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/QuantityUnit/");
            exit();
        }
        else{
            $_SESSION["error"] = "Единица измерения величины с такими данными уже существует.";

            header("Location: EditQuantityUnit.php?quantityUnitId=" . $_GET["quantityUnitId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditQuantityUnit.php?quantityUnitId=" . $_GET["quantityUnitId"]);
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $quantityUnits = QueryExecutor::getInstance()->getQuantityUnits($_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);
    $quantities = QueryExecutor::getInstance()->getQuantities("");
    $units = QueryExecutor::getInstance()->getUnits("");

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableQuantityUnits.php";
    exit();
}

if(!isset($_POST["action"])){
    $quantityUnits = QueryExecutor::getInstance()->getQuantityUnits($_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);
    $quantities = QueryExecutor::getInstance()->getQuantities("");
    $units = QueryExecutor::getInstance()->getUnits("");

    include "QuantityUnits.php";
}
?>