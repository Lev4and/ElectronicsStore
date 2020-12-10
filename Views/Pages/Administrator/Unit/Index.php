<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

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

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsUnit($_POST["name"])) {
            QueryExecutor::getInstance()->addUnit($_POST["name"], $_POST["designation"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/Unit/");
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
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsUnit($_POST["name"])) {
            QueryExecutor::getInstance()->updateUnit($_GET["unitId"], $_POST["name"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Unit/");
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

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $units = QueryExecutor::getInstance()->getUnits($_POST["inputSearch"]);

    include "Units.php";
}
?>