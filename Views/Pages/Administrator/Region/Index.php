<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

$countries = array();
$regions = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddRegion.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    $regionId = $_POST["selectedRegion"];

    header("Location: EditRegion.php?regionId=$regionId");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeRegion($_POST["selectedRegion"]);

    $countries = QueryExecutor::getInstance()->getCountries("");
    $regions = QueryExecutor::getInstance()->getRegions($_POST["countryId"], $_POST["inputSearch"]);

    include "Regions.php";
}

if(isset($_GET["action"]) && $_GET["action"] == "Предварительное применение фильтров"){
    $regions = QueryExecutor::getInstance()->getRegions($_POST["countryId"], $_POST["inputSearch"]);

    $_SESSION["preValues"] = array();

    foreach ($regions as $region){
        array_push($_SESSION["preValues"], $region["id"]);
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
        $regions = QueryExecutor::getInstance()->getRegions($_POST["countryId"], $_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableRegions.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать"){
    if(isset($_POST["countryId"]) && isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsRegion($_POST["countryId"], $_POST["name"])){
            QueryExecutor::getInstance()->addRegion($_POST["countryId"], $_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Region/");
            exit();
        }
        else{
            $_SESSION["error"] = "Регион с такими данными уже существует.";

            header("Location: AddRegion.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddRegion.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить"){
    if(isset($_POST["countryId"]) && isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsRegion($_POST["countryId"], $_POST["name"])){
            QueryExecutor::getInstance()->updateRegion($_GET["regionId"], $_POST["countryId"], $_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Region/");
            exit();
        }
        else{
            $_SESSION["error"] = "Регион с такими данными уже существует.";

            header("Location: EditRegion.php?regionId=" . $_GET["regionId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditRegion.php?regionId=" . $_GET["regionId"]);
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $regions = QueryExecutor::getInstance()->getRegions($_POST["countryId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($regions as $region){
        array_push($_SESSION["values"], $region["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableRegions.php";
    exit();
}

if(!isset($_POST["action"])){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $regions = QueryExecutor::getInstance()->getRegions($_POST["countryId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($regions as $region){
        array_push($_SESSION["values"], $region["id"]);
    }

    include "Regions.php";
}
?>