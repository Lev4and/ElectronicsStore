<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Классификации</title>
    <link rel="stylesheet" href="/CSS/Pages/Classifications.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/Toolbar.css">
    <link rel="stylesheet" href="/CSS/Elements/TableClassifications.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
</head>
<body>

<div class="main">
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";

    if(isset($_SESSION["user"]) && $_SESSION["user"]["role_name"] == "Администратор"){
        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuAdmin.php";
    }
    else{
        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuCustomer.php";
    }
    ?>
    <div class="content">
        <?php if(isset($_SESSION["user"]) && count($_SESSION["user"]) > 0 && $_SESSION["user"]["role_name"] == "Администратор"): ?>
            <div class="header-block">
                <h1>Классификации</h1>
            </div>
            <form action="http://electronicsstore/Views/Pages/Administrator/Classification/" method="post">
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Toolbar.php"; ?>
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableClassifications.php"; ?>
            </form>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Error.php"; ?>
            <?php $_SESSION["error"] = ""; ?>
        <?php else: ?>
            <?php $_SESSION["error"] = "У вас нет прав доступа на посещение данной страницы."; ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Error.php"; ?>
            <?php $_SESSION["error"] = ""; ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>