<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$roles = QueryExecutor::getInstance()->getRoles();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Регистрация</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/Registration.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/Form.css">
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
                <h1>Регистрация</h1>
            </div>
            <div class="form-block">
                <form action="http://electronicsstore/" method="post">
                    <div class="form-block-inputs">
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите должность:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select name="roleId">
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?php echo $role["id"]; ?>"><?php echo $role["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Введите логин:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-text">
                                    <input type="text" name="login" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Введите пароль:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-password">
                                    <input type="password" name="password" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Подтвердите пароль:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-password">
                                    <input type="password" name="repeatPassword" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-block-actions">
                        <div class="form-block-actions-button">
                            <input class="action-button" id="login-button" type="submit" name="action" value="Зарегистрироваться"/>
                        </div>
                        <div class="form-block-actions-link">
                            <a class="link" href="Authorization.php">Войти</a>
                        </div>
                    </div>
                </form>
            </div>
            <?php VisibleError::showError(); ?>
        <?php else: ?>
            <?php Access::denyRegistration(); ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>