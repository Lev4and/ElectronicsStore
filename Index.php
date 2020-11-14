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

        header("Location: /Views/Pages/Main.html.php");
        exit();
    }
    else{
        header("Location: /Views/Pages/Authorization.html.php");
        exit();
    }
}

include("./Views/Pages/Main.html.php");
?>