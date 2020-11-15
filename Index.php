<?php
require "Logic/Database/QueryExecutor.php";

session_start();

if(!isset($_SESSION["user"])){
    $_SESSION["user"] = array();
}

if(isset($_POST["action"]) && $_POST["action"] == "Авторизоваться"){
    $login = $_POST["login"];
    $password = $_POST["password"];

    if(QueryExecutor::getInstance()->authorization($login, $password)){
        $_SESSION["user"] = QueryExecutor::getInstance()->getUser($login);
    }
    else{
        header("Location: /Views/Pages/Authorization.html.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Выход"){
    $_SESSION["user"] = array();
}

include("./Views/Pages/Main.html.php");
?>