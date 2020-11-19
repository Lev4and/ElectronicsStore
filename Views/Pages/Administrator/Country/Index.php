<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

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

if(isset($_POST["action"]) && $_POST["action"] == "Записать"){
    if(isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsCountry($_POST["name"])){
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->addCountry($_POST["name"], $fileName);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Country/");
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

            header("Location: http://electronicsstore/Views/Pages/Administrator/Country/");
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

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $countries = QueryExecutor::getInstance()->getCountries($_POST["inputSearch"]);

    include "Countries.php";
}
?>