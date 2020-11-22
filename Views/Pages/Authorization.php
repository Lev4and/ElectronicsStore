<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Авторизация</title>
    <link rel="stylesheet" href="/CSS/Pages/Authorization.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
</head>
<body>
<div class="main">
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Menu.php";
    ?>
    <div class="content">
        <?php if(Access::isAuthorized()): ?>
            <div class="header-block">
                <h1>Авторизация</h1>
            </div>
            <form action="http://electronicsstore/" method="post">
                <div class="form-block">
                    <table class="form-block-table">
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Введите логин:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <input type="text" name="login" value="">
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Введите пароль:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <input type="password" name="password" value="">
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-button" colspan="2">
                                <input class="action-button" id="login-button" type="submit" name="action" value="Авторизоваться"/>
                                <a class="link" href="Registration.php">Нет аккаунта?</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <?php VisibleError::showError(); ?>
        <?php else: ?>
            <?php Access::denyAuthorization(); ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php";?>
</div>
</body>
</html>