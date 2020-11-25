<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$warehouses = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddWarehouse.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditWarehouse.php?warehouseId=" . $_POST["selectedWarehouse"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeWarehouse($_POST["selectedWarehouse"]);

    $countries = QueryExecutor::getInstance()->getCountries("");
    $warehouses = QueryExecutor::getInstance()->getWarehouses($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["street_id"], $_POST["house_id"], $_POST["inputSearch"]);

    include "Warehouses.php";
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

if(isset($_POST["action"]) && $_POST["action"] == "Дома"){
    if(isset($_POST["streetId"]) && $_POST["streetId"] > 0){
        echo '<option value="">Выберите дом</option>';
        foreach (QueryExecutor::getInstance()->getHouses(null, null, null, $_POST["streetId"], "") as $house){
            echo '<option value="' . $house["id"] . '">' . $house["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите дом</option>';
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["houseId"]) && $_POST["houseId"] > 0 && iconv_strlen($_POST["phoneNumber"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsWarehouse($_POST["houseId"], $_POST["phoneNumber"])) {
            QueryExecutor::getInstance()->addWarehouse($_POST["houseId"], $_POST["phoneNumber"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Warehouse/");
            exit();
        }
        else{
            $_SESSION["error"] = "Склад с такими данными уже существует.";

            header("AddWarehouse: AddHouse.php");
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
    if (isset($_POST["houseId"]) && $_POST["houseId"] > 0 && iconv_strlen($_POST["phoneNumber"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsWarehouse($_POST["houseId"], $_POST["phoneNumber"])) {
            QueryExecutor::getInstance()->updateWarehouse($_GET["warehouseId"], $_POST["houseId"], $_POST["phoneNumber"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Warehouse/");
            exit();
        }
        else{
            $_SESSION["error"] = "Склад с такими данными уже существует.";

            header("Location: EditWarehouse.php?warehouseId=" . $_GET["warehouseId"]);
            exit();
        }
    }
    else {
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditWarehouse.php?warehouseId=" . $_GET["warehouseId"]);
        exit();
    }
}

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $warehouses = QueryExecutor::getInstance()->getWarehouses($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["street_id"], $_POST["house_id"], $_POST["inputSearch"]);

    include "Warehouses.php";
}
?>