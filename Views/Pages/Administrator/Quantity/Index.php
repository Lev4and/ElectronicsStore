<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

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

if(isset($_POST["action"]) && $_POST["action"] == "Обновить счетчик количества записей"){
    $countValues = count($_SESSION["values"]);
    $word = NumWord::numberWord($countValues, array('запись', 'записи', 'записей'));

    echo "{$word}";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Поменять страницу"){
    if(isset($_GET["numberPage"]) && $_GET["numberPage"] > 0){
        $quantities = QueryExecutor::getInstance()->getQuantities($_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableQuantities.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
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

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $quantities = QueryExecutor::getInstance()->getQuantities($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($quantities as $quantity){
        array_push($_SESSION["values"], $quantity["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableQuantities.php";
    exit();
}

if(!isset($_POST["action"])){
    $quantities = QueryExecutor::getInstance()->getQuantities($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($quantities as $quantity){
        array_push($_SESSION["values"], $quantity["id"]);
    }

    include "Quantities.php";
}
?>