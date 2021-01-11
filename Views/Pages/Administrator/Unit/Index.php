<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

$units = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddUnit.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditUnit.php?unitId=" . $_POST["selectedUnit"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeUnit($_POST["selectedUnit"]);

    $units = QueryExecutor::getInstance()->getUnits($_POST["inputSearch"]);

    include "Units.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Обновить счетчик количества записей"){
    $countValues = count($_SESSION["values"]);
    $word = NumWord::numberWord($countValues, array('запись', 'записи', 'записей'));

    echo "{$word}";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Поменять страницу"){
    if(isset($_GET["numberPage"]) && $_GET["numberPage"] > 0){
        $units = QueryExecutor::getInstance()->getUnits($_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableUnits.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsUnit($_POST["name"])) {
            QueryExecutor::getInstance()->addUnit($_POST["name"], $_POST["designation"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Unit/");
            exit();
        }
        else{
            $_SESSION["error"] = "Единица измерения с такими данными уже существует.";

            header("Location: AddUnit.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddUnit.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsUnit($_POST["name"], $_POST["designation"])) {
            QueryExecutor::getInstance()->updateUnit($_GET["unitId"], $_POST["name"], $_POST["designation"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Unit/");
            exit();
        }
        else{
            $_SESSION["error"] = "Единица измерения с такими данными уже существует.";

            header("Location: EditUnit.php?unitId=" . $_GET["unitId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditUnit.php?unitId=" . $_GET["unitId"]);
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $units = QueryExecutor::getInstance()->getUnits($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($units as $unit){
        array_push($_SESSION["values"], $unit["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableUnits.php";
    exit();
}

if(!isset($_POST["action"])){
    $units = QueryExecutor::getInstance()->getUnits($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($units as $unit){
        array_push($_SESSION["values"], $unit["id"]);
    }

    include "Units.php";
}
?>