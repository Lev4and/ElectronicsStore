<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Includes/Helpers.inc.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Магазин электроники</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
</head>
<body>
<div class="main">
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.html.php"; ?>
    <div class="content">
        <?php if(isset($_SESSION["user"]) && $_SESSION["user"]["role_name"] == "Администратор"){
            include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuAdmin.html.php";
        }
        else{
            include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuCustomer.html.php";
        }
        ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.html.php"; ?>
</div>
</body>
</html>