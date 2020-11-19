<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$cities = array();
$streets = array();
$regions = array();
$countries = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddStreet.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    $streetId = $_POST["selectedStreet"];

    header("Location: EditStreet.php?streetId=$streetId");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeStreet($_POST["selectedStreet"]);

    $countries = QueryExecutor::getInstance()->getCountries("");
    $streets = QueryExecutor::getInstance()->getStreets($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["inputSearch"]);

    include "Streets.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать"){
    if(isset($_POST["cityId"]) && $_POST["cityId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsStreet($_POST["cityId"], $_POST["name"])){
            QueryExecutor::getInstance()->addStreet($_POST["cityId"], $_POST["name"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Street/");
            exit();
        }
        else{
            $_SESSION["error"] = "Улица с такими данными уже существует.";

            header("Location: AddStreet.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddStreet.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить"){
    if(isset($_POST["cityId"]) && $_POST["cityId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsStreet($_POST["cityId"], $_POST["name"])) {
            QueryExecutor::getInstance()->updateStreet($_GET["streetId"], $_POST["cityId"], $_POST["name"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Street/");
            exit();
        }
        else{
            $_SESSION["error"] = "Улица с такими данными уже существует.";

            header("Location: EditStreet.php?streetId=". $_GET["streetId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditStreet.php?streetId=". $_GET["streetId"]);
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Регионы"){
    if(isset($_POST["countryId"]) && $_POST["countryId"] > 0){

        echo '<option value="">Выберите регион</option>';
        foreach (QueryExecutor::getInstance()->getRegions($_POST["countryId"], "") as $region){
            echo '<option value="' .$region["id"] . '">' . $region["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите регион</option>';
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Города"){
    if(isset($_POST["regionId"]) && $_POST["regionId"] > 0){
        echo '<option value="">Выберите город</option>';
        foreach (QueryExecutor::getInstance()->getCities(null, $_POST["regionId"], "") as $city){
            echo '<option value="' .$city["id"] . '">' . $city["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите город</option>';
    }
}

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $streets = QueryExecutor::getInstance()->getStreets($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["inputSearch"]);

    include "Streets.php";
}
?>