<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

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

if(isset($_POST["action"]) && $_POST["action"] == "Записать"){
    if(isset($_POST["countryId"]) && isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsRegion($_POST["countryId"], $_POST["name"])){
            QueryExecutor::getInstance()->addRegion($_POST["countryId"], $_POST["name"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Region/");
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

            header("Location: http://electronicsstore/Views/Pages/Administrator/Region/");
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

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $regions = QueryExecutor::getInstance()->getRegions($_POST["countryId"], $_POST["inputSearch"]);

    include "Regions.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Сбросить фильтры"){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $regions = QueryExecutor::getInstance()->getRegions(null, "");

    include "Regions.php";
}
?>