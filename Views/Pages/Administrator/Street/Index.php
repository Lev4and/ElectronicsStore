<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

$cities = array();
$streets = array();
$regions = array();
$countries = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddStreet.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditStreet.php?streetId=" . $_POST["selectedStreet"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeStreet($_POST["selectedStreet"]);

    $countries = QueryExecutor::getInstance()->getCountries("");
    $streets = QueryExecutor::getInstance()->getStreets($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["inputSearch"]);

    include "Streets.php";
}

if(isset($_GET["action"]) && $_GET["action"] == "Предварительное применение фильтров"){
    $streets = QueryExecutor::getInstance()->getStreets($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["inputSearch"]);

    $_SESSION["preValues"] = array();

    foreach ($streets as $street){
        array_push($_SESSION["preValues"], $street["id"]);
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
        $streets = QueryExecutor::getInstance()->getStreets($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableStreets.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать"){
    if(isset($_POST["cityId"]) && $_POST["cityId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsStreet($_POST["cityId"], $_POST["name"])){
            QueryExecutor::getInstance()->addStreet($_POST["cityId"], $_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Street/");
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

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Street/");
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

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $streets = QueryExecutor::getInstance()->getStreets($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($streets as $street){
        array_push($_SESSION["values"], $street["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableStreets.php";
    exit();
}

if(!isset($_POST["action"])){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $streets = QueryExecutor::getInstance()->getStreets($_POST["countryId"], $_POST["regionId"], $_POST["cityId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($streets as $street){
        array_push($_SESSION["values"], $street["id"]);
    }

    include "Streets.php";
}
?>