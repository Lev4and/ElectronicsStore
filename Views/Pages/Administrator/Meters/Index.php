<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$meters = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddMeter.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditMeter.php?meterId=" . $_POST["selectedMeter"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeMeter($_POST["selectedMeter"]);

    $meters = QueryExecutor::getInstance()->getMeters($_POST["inputSearch"]);

    include "Meters.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsMeter($_POST["name"])) {
            QueryExecutor::getInstance()->addMeter($_POST["name"], $_POST["designation"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Meters/");
            exit();
        }
        else{
            $_SESSION["error"] = "Измеритель с такими данными уже существует.";

            header("Location: AddMeter.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddMeter.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsMeter($_POST["name"], $_POST["designation"])) {
            QueryExecutor::getInstance()->updateMeter($_GET["meterId"], $_POST["name"], $_POST["designation"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Meters/");
            exit();
        }
        else{
            $_SESSION["error"] = "Измеритель с такими данными уже существует.";

            header("Location: EditMeter.php?meterId=" . $_GET["meterId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditMeter.php?meterId=" . $_GET["meterId"]);
        exit();
    }
}

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $meters = QueryExecutor::getInstance()->getMeters($_POST["inputSearch"]);

    include "Meters.php";
}
?>