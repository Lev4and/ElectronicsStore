<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Авторизация</title>
    <link rel="stylesheet" href="/CSS/Pages/Authorization.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
</head>
<body>
<div class="main">
    <header>
        <div class="header-block">
            <h1>Авторизация</h1>
        </div>
    </header>
    <form action="http://electronicsstore/Index.php" method="post">
        <div class="form-block">
            <table class="form-block-table">
                <tr class="form-block-table-tr">
                    <td class="form-block-table-td-label">
                        <label>Введите логин:</label>
                    </td>
                    <td class="form-block-table-td-text">
                        <input type="text" name="login" value="">
                    </td>
                </tr>
                <tr class="form-block-table-tr">
                    <td class="form-block-table-td-label">
                        <label>Введите пароль:</label>
                    </td>
                    <td class="form-block-table-td-password">
                        <input type="password" name="password" value="">
                    </td>
                </tr>
                <tr class="form-block-table-tr">
                    <td class="form-block-table-td-button" colspan="2">
                        <input class="action-button" id="login-button" type="submit" name="action" value="Авторизоваться"/>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
</body>
</html>