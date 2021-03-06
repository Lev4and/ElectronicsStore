<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

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

if(isset($_GET["action"]) && $_GET["action"] == "Предварительное применение фильтров"){
    $houses = QueryExecutor::getInstance()->getHouses($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["streetId"], $_POST["inputSearch"]);

    $_SESSION["preValues"] = array();

    foreach ($houses as $house){
        array_push($_SESSION["preValues"], $house["id"]);
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
        $houses = QueryExecutor::getInstance()->getHouses($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["streetId"], $_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableHouses.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["streetId"]) && $_POST["streetId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsHouse($_POST["streetId"], $_POST["name"])) {
            QueryExecutor::getInstance()->addHouse($_POST["streetId"], $_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/House/");
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

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/House/");
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

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $houses = QueryExecutor::getInstance()->getHouses($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["streetId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($houses as $house){
        array_push($_SESSION["values"], $house["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableHouses.php";
    exit();
}

if(!isset($_POST["action"])){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $houses = QueryExecutor::getInstance()->getHouses($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["streetId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($houses as $house){
        array_push($_SESSION["values"], $house["id"]);
    }

    include "Houses.php";
}
?>