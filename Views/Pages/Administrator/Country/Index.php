<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$_SESSION["pageNumber"] = 1;

$countries = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddCountry.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditCountry.php?countryId=" . $_POST["selectedCountry"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCountry($_POST["selectedCountry"]);

    $countries = QueryExecutor::getInstance()->getCountries($_POST["inputSearch"]);

    include "Countries.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Обновить счетчик количества записей"){
    $countValues = count($_SESSION["values"]);
    $word = NumWord::numberWord($countValues, array('запись', 'записи', 'записей'));

    echo "{$word}";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Поменять страницу"){
    if(isset($_GET["numberPage"]) && $_GET["numberPage"] > 0){
        $countries = QueryExecutor::getInstance()->getCountries($_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCountries.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать"){
    if(isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsCountry($_POST["name"])){
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->addCountry($_POST["name"], $fileName);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/Country/");
            exit();
        }
        else{
            $_SESSION["error"] = "Страна с такими данными уже существует.";

            header("Location: AddCountry.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddCountry.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить"){
    if(isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsCountry($_POST["name"]) || $_GET["flag"] != $_FILES["selectedImage"]["tmp_name"]){
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->updateCountry($_GET["countryId"], $_POST["name"], iconv_strlen($fileName) > 0 ? $fileName : $_GET["flag"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/Country/");
            exit();
        }
        else{
            $_SESSION["error"] = "Страна с такими данными уже существует.";

            header("Location: EditCountry.php?countryId=" . $_GET["countryId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditCountry.php?countryId=" . $_GET["countyId"]);
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $countries = QueryExecutor::getInstance()->getCountries($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($countries as $country){
        array_push($_SESSION["values"], $country["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCountries.php";
    exit();
}

if(!isset($_POST["action"])){
    $countries = QueryExecutor::getInstance()->getCountries($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($countries as $country){
        array_push($_SESSION["values"], $country["id"]);
    }

    include "Countries.php";
}
?>