<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$cities = array();
$regions = array();
$countries = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddCity.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    $cityId = $_POST["selectedCity"];

    header("Location: EditCity.php?cityId=$cityId");
    exit();
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

if(isset($_POST["action"]) && $_POST["action"] == "Записать"){
    if(isset($_POST["countryId"]) && isset($_POST["regionId"]) && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsCity($_POST["regionId"], $_POST["name"])){
            QueryExecutor::getInstance()->addCity($_POST["regionId"], $_POST["name"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/City/");
            exit();
        }
        else{
            $_SESSION["error"] = "Город с такими данными уже существует.";

            header("Location: AddCity.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddCity.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить"){
    if(isset($_POST["countryId"]) && $_POST["countryId"] > 0 && isset($_POST["regionId"]) && $_POST["regionId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsCity($_POST["regionId"], $_POST["name"])){
            QueryExecutor::getInstance()->updateCity($_GET["cityId"], $_POST["regionId"], $_POST["name"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/City/");
            exit();
        }
        else{
            $_SESSION["error"] = "Город с такими данными уже существует.";

            header("Location: EditCity.php?cityId=" . $_GET["cityId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditCity.php?cityId=" . $_GET["cityId"]);
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCity($_POST["selectedCity"]);

    $countries = QueryExecutor::getInstance()->getCountries("");
    $cities = QueryExecutor::getInstance()->getCities($_POST["countryId"], $_POST["regionId"], $_POST["inputSearch"]);

    include "Cities.php";
}

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $cities = QueryExecutor::getInstance()->getCities($_POST["countryId"], $_POST["regionId"], $_POST["inputSearch"]);

    include "Cities.php";
}
?>