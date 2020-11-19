<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$classifications = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddClassification.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditClassification.php?classificationId=" . $_POST["selectedClassification"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeClassification($_POST["selectedClassification"]);

    $classifications = QueryExecutor::getInstance()->getClassifications($_POST["inputSearch"]);

    include "Classifications.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать"){
    if(isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsClassification($_POST["name"])){
            $classificationName = $_POST["name"];

            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->addClassification($classificationName, $fileName);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Classification/");
            exit();
        }
        else{
            $_SESSION["error"] = "Классификация с такими данными уже существует.";

            header("Location: AddClassification.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddClassification.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить"){
    if(isset($_POST["name"]) && iconv_strlen($_POST["name"], "UTF-8") > 0){
        if(!QueryExecutor::getInstance()->containsClassification($_POST["name"]) || $_GET["photo"] != $_FILES["selectedImage"]["tmp_name"]){
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->updateClassification($_GET["classificationId"], $_POST["name"], iconv_strlen($fileName) > 0 ? $fileName : $_GET["photo"]);

            header("Location: http://electronicsstore/Views/Pages/Administrator/Classification/");
            exit();
        }
        else{
            $_SESSION["error"] = "Классификация с такими данными уже существует.";

            header("Location: EditClassification.php?classificationId=" . $_GET["classificationId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditClassification.php?classificationId=" . $_GET["classificationId"]);
        exit();
    }
}

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $classifications = QueryExecutor::getInstance()->getClassifications($_POST["inputSearch"]);

    include "Classifications.php";
}
?>