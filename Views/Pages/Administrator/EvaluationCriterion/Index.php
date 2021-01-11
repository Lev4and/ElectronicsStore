<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Functional/NumWord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$evaluationCriterions = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddEvaluationCriterion.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditEvaluationCriterion.php?evaluationCriterionId=" . $_POST["selectedEvaluationCriterion"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeEvaluationCriterion($_POST["selectedEvaluationCriterion"]);

    $evaluationCriterions = QueryExecutor::getInstance()->getEvaluationCriterions($_POST["inputSearch"]);

    include "EvaluationCriterions.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Обновить счетчик количества записей"){
    $countValues = count($_SESSION["values"]);
    $word = NumWord::numberWord($countValues, array('запись', 'записи', 'записей'));

    echo "{$word}";
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Поменять страницу"){
    if(isset($_GET["numberPage"]) && $_GET["numberPage"] > 0){
        $evaluationCriterions = QueryExecutor::getInstance()->getEvaluationCriterions($_POST["inputSearch"]);

        $_SESSION["pageNumber"] = $_GET["numberPage"];

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableEvaluationCriterions.php";
    }

    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "Обновить нумерацию страниц"){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Pagination.php";
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsEvaluationCriterion($_POST["name"])) {
            QueryExecutor::getInstance()->addEvaluationCriterion($_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/EvaluationCriterion/");
            exit();
        }
        else{
            $_SESSION["error"] = "Критерия оценивания с такими данными уже существует.";

            header("Location: AddEvaluationCriterion.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddEvaluationCriterion.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsEvaluationCriterion($_POST["name"])) {
            QueryExecutor::getInstance()->updateEvaluationCriterion($_GET["evaluationCriterionId"], $_POST["name"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/EvaluationCriterion/");
            exit();
        }
        else{
            $_SESSION["error"] = "Критерия оценивания с такими данными уже существует.";

            header("Location: EditEvaluationCriterion.php?evaluationCriterionId={$_GET["evaluationCriterionId"]}");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditEvaluationCriterion.php?evaluationCriterionId={$_GET["evaluationCriterionId"]}");
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $evaluationCriterions = QueryExecutor::getInstance()->getEvaluationCriterions($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($evaluationCriterions as $evaluationCriterion){
        array_push($_SESSION["values"], $evaluationCriterion["id"]);
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableEvaluationCriterions.php";
    exit();
}

if(!isset($_POST["action"])){
    $evaluationCriterions = QueryExecutor::getInstance()->getEvaluationCriterions($_POST["inputSearch"]);

    $_SESSION["values"] = array();

    foreach ($evaluationCriterions as $evaluationCriterion){
        array_push($_SESSION["values"], $evaluationCriterion["id"]);
    }

    include "EvaluationCriterions.php";
}
?>