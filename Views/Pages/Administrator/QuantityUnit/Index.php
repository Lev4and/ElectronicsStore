<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

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

if(isset($_GET["action"]) && $_GET["action"] == "Предварительное применение фильтров"){
    $quantityUnits = QueryExecutor::getInstance()->getQuantityUnits($_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);

    $_SESSION["preValues"] = array();

    foreach ($quantityUnits as $quantityUnit){
        array_push($_SESSION["preValues"], $quantityUnit["id"]);
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
        $quantityUnits = QueryExecutor::getInstance()->getQuantityUnits($_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableQuantityUnits.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
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

    $_SESSION["values"] = array();

    foreach ($quantityUnits as $quantityUnit){
        array_push($_SESSION["values"], $quantityUnit["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableQuantityUnits.php";
    exit();
}

if(!isset($_POST["action"])){
    $quantityUnits = QueryExecutor::getInstance()->getQuantityUnits($_POST["quantityId"], $_POST["unitId"], $_POST["inputSearch"]);
    $quantities = QueryExecutor::getInstance()->getQuantities("");
    $units = QueryExecutor::getInstance()->getUnits("");

    $_SESSION["values"] = array();

    foreach ($quantityUnits as $quantityUnit){
        array_push($_SESSION["values"], $quantityUnit["id"]);
    }

    include "QuantityUnits.php";
}
?>