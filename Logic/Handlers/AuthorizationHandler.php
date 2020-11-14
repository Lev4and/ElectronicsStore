<?php
require "../Database/QueryExecutor.php";

$login = $_POST["login"];
$password = $_POST["password"];

if(QueryExecutor::getInstance()->authorization($login, $password)){
    $_SESSION["user"][] = QueryExecutor::getInstance()->getUser($login);

    header("Location: Index.php");
}
else{
    header("Location: .");
}
?>