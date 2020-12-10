<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$quantities = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddQuantity.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditQuantity.php?quantityId=" . $_POST["selectedQuantity"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeQuantity($_POST["selectedQuantity"]);

    $quantities = QueryExecutor::getInstance()->getQuantities($_POST["inputSearch"]);

    include "Quantities.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsQuantity($_POST["name"])) {
            QueryExecutor::getInstance()->addQuantity($_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Quantity/");
            exit();
        }
        else{
            $_SESSION["error"] = "Величина с такими данными уже существует.";

            header("Location: AddQuantity.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddQuantity.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsQuantity($_POST["name"])) {
            QueryExecutor::getInstance()->updateQuantity($_GET["quantityId"], $_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Quantity/");
            exit();
        }
        else{
            $_SESSION["error"] = "Величина с такими данными уже существует.";

            header("Location: EditQuantity.php?quantityId=" . $_GET["quantityId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditQuantity.php?quantityId=" . $_GET["quantityId"]);
        exit();
    }
}

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $quantities = QueryExecutor::getInstance()->getQuantities($_POST["inputSearch"]);

    include "Quantities.php";
}
?>