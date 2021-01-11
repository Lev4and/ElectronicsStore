<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$cities = array();
$regions = array();
$countries = array();

$_SESSION["pageNumber"] = 1;

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddCity.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditCity.php?cityId=" . $_POST["selectedCity"]);
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

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCity($_POST["selectedCity"]);

    $countries = QueryExecutor::getInstance()->getCountries("");
    $cities = QueryExecutor::getInstance()->getCities($_POST["countryId"], $_POST["regionId"], $_POST["inputSearch"]);

    include "Cities.php";
}

if(isset($_GET["action"]) && $_GET["action"] == "Предварительное применение фильтров"){
    $cities = QueryExecutor::getInstance()->getCities($_POST["countryId"], $_POST["regionId"], $_POST["inputSearch"]);

    $_SESSION["preValues"] = array();

    foreach ($cities as $city){
        array_push($_SESSION["preValues"], $city["id"]);
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
        $cities = QueryExecutor::getInstance()->getCities($_POST["countryId"], $_POST["regionId"], $_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCities.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать"){
    if(isset($_POST["countryId"]) && isset($_POST["regionId"]) && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsCity($_POST["regionId"], $_POST["name"])){
            QueryExecutor::getInstance()->addCity($_POST["regionId"], $_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/City/");
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

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/City/");
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

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $cities = QueryExecutor::getInstance()->getCities($_POST["countryId"], $_POST["regionId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($cities as $city){
        array_push($_SESSION["values"], $city["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCities.php";
    exit();
}

if(!isset($_POST["action"])){
    $countries = QueryExecutor::getInstance()->getCountries("");
    $cities = QueryExecutor::getInstance()->getCities($_POST["countryId"], $_POST["regionId"], $_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($cities as $city){
        array_push($_SESSION["values"], $city["id"]);
    }

    include "Cities.php";
}
?>