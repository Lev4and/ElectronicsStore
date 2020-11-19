<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$houses = array();
$cities = array();
$streets = array();
$regions = array();
$countries = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddHouse.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditHouse.php?houseId=" . $_POST["selectedHouse"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeHouse($_POST["selectedHouse"]);

    $countries = QueryExecutor::getInstance()->getCountries("");
    $houses = QueryExecutor::getInstance()->getHouses($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["streetId"], $_POST["inputSearch"]);

    include "Houses.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Регионы"){
    if(isset($_POST["countryId"]) && $_POST["countryId"] > 0){
        echo '<option value="">Выберите регион</option>';
        foreach (QueryExecutor::getInstance()->getRegions($_POST["countryId"], "") as $region){
            echo '<option value="' . $region["id"] . '">' . $region["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите регион</option>';
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["streetId"]) && $_POST["streetId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsHouse($_POST["streetId"], $_POST["name"])) {
            QueryExecutor::getInstance()->addHouse($_POST["streetId"], $_POST["name"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/House/");
            exit();
        }
        else{
            $_SESSION["error"] = "Дом с такими данными уже существует.";

            header("Location: AddHouse.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddHouse.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["streetId"]) && $_POST["streetId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsHouse($_POST["streetId"], $_POST["name"])) {
            QueryExecutor::getInstance()->updateHouse($_GET["houseId"], $_POST["streetId"], $_POST["name"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/House/");
            exit();
        }
        else{
            $_SESSION["error"] = "Дом с такими данными уже существует.";

            header("Location: EditHouse.php?houseId=" . $_GET["houseId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditHouse.php?houseId=" . $_GET["houseId"]);
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Города"){
    if(isset($_POST["regionId"]) && $_POST["regionId"] > 0){
        echo '<option value="">Выберите город</option>';
        foreach (QueryExecutor::getInstance()->getCities(null, $_POST["regionId"], "") as $city){
            echo '<option value="' . $city["id"] . '">' . $city["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите город</option>';
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Улицы"){
    if(isset($_POST["cityId"]) && $_POST["cityId"] > 0){
        echo '<option value="">Выберите улицу</option>';
        foreach (QueryExecutor::getInstance()->getStreets(null, null, $_POST["cityId"], "") as $street){
            echo '<option value="' . $street["id"] . '">' . $street["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите улицу</option>';
    }
}

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $houses = QueryExecutor::getInstance()->getHouses($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["streetId"], $_POST["inputSearch"]);

    include "Houses.php";
}
?>