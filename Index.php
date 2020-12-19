<?php
session_start();

require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

if(!isset($_SESSION["basket"])){
    $_SESSION["basket"] = array();
}

if(!isset($_SESSION["user"])){
    $_SESSION["user"] = array();
}

if(!isset($_SESSION["error"])){
    $_SESSION["error"] = "";
}

if(isset($_SESSION["error"]) && iconv_strlen($_SESSION["error"], "UTF-8") > 0){
    $_SESSION["error"] = "";
}

if(isset($_POST["action"]) && $_POST["action"] == "Авторизоваться"){
    if(QueryExecutor::getInstance()->authorization($_POST["login"], $_POST["password"])){
        $_SESSION["user"] = QueryExecutor::getInstance()->getUser($_POST["login"]);
        $_SESSION["basket"] = array();
    }
    else{
        $_SESSION["error"] = "Вы ввели неверный логин или пароль.";

        header("Location: http://electronicsstore/Views/Pages/Authorization.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Зарегистрироваться"){
    $roleId = $_POST["roleId"];

    $login = $_POST["login"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeatPassword"];

    if(isset($roleId) && isset($login) && iconv_strlen($login, "UTF-8") > 0 && isset($password) && iconv_strlen($password, "UTF-8") > 0 && isset($repeatPassword) && $password == $repeatPassword){
        if(!QueryExecutor::getInstance()->containsUser($login)){
            QueryExecutor::getInstance()->registration($roleId, $login, $password);

            header("Location: http://electronicsstore/Views/Pages/Authorization.php");
            exit();
        }
        else{
            $_SESSION["error"] = "Пользователь с таким логином уже существует.";

            header("Location: http://electronicsstore/Views/Pages/Registration.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Вы указали неверные данные.";

        header("Location: http://electronicsstore/Views/Pages/Registration.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Выход"){
    $_SESSION["user"] = array();
    $_SESSION["basket"] = array();
}

include("./Views/Pages/Main.php");
?>