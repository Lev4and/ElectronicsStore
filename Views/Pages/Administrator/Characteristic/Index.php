<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

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

if(isset($_POST["action"]) && $_POST["action"] == "Обновить счетчик количества записей"){
    $countValues = count($_SESSION["values"]);
    $word = NumWord::numberWord($countValues, array('запись', 'записи', 'записей'));

    echo "{$word}";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Поменять страницу"){
    if(isset($_GET["numberPage"]) && $_GET["numberPage"] > 0){
        $characteristics = QueryExecutor::getInstance()->getCharacteristics($_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCharacteristics.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsCharacteristic($_POST["name"])) {
            $characteristicId = QueryExecutor::getInstance()->addCharacteristic($_POST["name"]);

            if(isset($_POST["quantityUnits"]) && count($_POST["quantityUnits"]) > 0){
                foreach ($_POST["quantityUnits"] as $key => $value){
                    QueryExecutor::getInstance()->addCharacteristicQuantityUnit($characteristicId, $value);
                }
            }

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
        if (!QueryExecutor::getInstance()->containsCharacteristic($_POST["name"]) || $_GET["countQuantityUnits"] != count($_POST["quantityUnits"])) {
            QueryExecutor::getInstance()->updateCharacteristic($_GET["characteristicId"], $_POST["name"]);
            QueryExecutor::getInstance()->removeAllCharacteristicQuantityUnits($_GET["characteristicId"]);

            if(isset($_POST["quantityUnits"]) && count($_POST["quantityUnits"]) > 0){
                foreach ($_POST["quantityUnits"] as $key => $value){
                    QueryExecutor::getInstance()->addCharacteristicQuantityUnit($_GET["characteristicId"], $value);
                }
            }

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

    $_SESSION["values"] = array();

    foreach ($characteristics as $characteristic){
        array_push($_SESSION["values"], $characteristic["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCharacteristics.php";
    exit();
}

if(!isset($_POST["action"])){
    $characteristics = QueryExecutor::getInstance()->getCharacteristics($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($characteristics as $characteristic){
        array_push($_SESSION["values"], $characteristic["id"]);
    }

    include "Characteristics.php";
}
?>