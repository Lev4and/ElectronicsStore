<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$sections = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddSection.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditSection.php?sectionId=" . $_POST["selectedSection"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeSection($_POST["selectedSection"]);

    $sections = QueryExecutor::getInstance()->getSections($_POST["inputSearch"]);

    include "Sections.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Обновить счетчик количества записей"){
    $countValues = count($_SESSION["values"]);
    $word = NumWord::numberWord($countValues, array('запись', 'записи', 'записей'));

    echo "{$word}";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Поменять страницу"){
    if(isset($_GET["numberPage"]) && $_GET["numberPage"] > 0){
        $sections = QueryExecutor::getInstance()->getSections($_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableSections.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsSection($_POST["name"])) {
            QueryExecutor::getInstance()->addSection($_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Section/");
            exit();
        }
        else{
            $_SESSION["error"] = "Раздел характеристики с такими данными уже существует.";

            header("Location: AddSection.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddSection.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsSection($_POST["name"])) {
            QueryExecutor::getInstance()->updateSection($_GET["sectionId"], $_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Section/");
            exit();
        }
        else{
            $_SESSION["error"] = "Раздел характеристики с такими данными уже существует.";

            header("Location: EditSection.php?sectionId={$_GET["sectionId"]}");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditSection.php?sectionId={$_GET["sectionId"]}");
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $sections = QueryExecutor::getInstance()->getSections($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($sections as $section){
        array_push($_SESSION["values"], $section["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableSections.php";
    exit();
}

if(!isset($_POST["action"])){
    $sections = QueryExecutor::getInstance()->getSections($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($sections as $section){
        array_push($_SESSION["values"], $section["id"]);
    }

    include "Sections.php";
}
?>