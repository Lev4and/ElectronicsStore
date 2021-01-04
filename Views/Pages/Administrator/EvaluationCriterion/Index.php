<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

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

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableEvaluationCriterions.php";
    exit();
}

if(!isset($_POST["action"])){
    $evaluationCriterions = QueryExecutor::getInstance()->getEvaluationCriterions($_POST["inputSearch"]);

    include "EvaluationCriterions.php";
}
?>