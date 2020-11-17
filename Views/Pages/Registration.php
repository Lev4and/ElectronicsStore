<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Регистрация</title>
    <link rel="stylesheet" href="/CSS/Pages/Registration.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
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
    require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";

    if(isset($_SESSION["user"]) && $_SESSION["user"]["role_name"] == "Администратор"){
        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuAdmin.php";
    }
    else{
        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuCustomer.php";
    }

    $roles = QueryExecutor::getInstance()->getRoles();
    ?>
    <div class="content">
        <?php if(!isset($_SESSION["user"]) || count($_SESSION["user"]) == 0): ?>
            <div class="header-block">
                <h1>Регистрация</h1>
            </div>
            <form action="http://electronicsstore/" method="post">
                <div class="form-block">
                    <table class="form-block-table">
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите должность:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select name="roleId">
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?php echo $role["id"]; ?>"><?php echo $role["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
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
                            <td class="form-block-table-td-label">
                                <label>Подтвердите пароль:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <input type="password" name="repeatPassword" value="">
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-button" colspan="2">
                                <input class="action-button" id="login-button" type="submit" name="action" value="Зарегистрироваться"/>
                                <a class="link" href="Authorization.php">Войти</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Error.php"; ?>
            <?php $_SESSION["error"] = ""; ?>
        <?php else: ?>
            <?php $_SESSION["error"] = "Вы не можете зарегистрироваться, так как вы авторизованы."; ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Error.php"; ?>
            <?php $_SESSION["error"] = ""; ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>