<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$countries = QueryExecutor::getInstance()->getCountries("");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Добавление региона</title>
    <link rel="stylesheet" href="/CSS/Pages/AddRegion.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
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
        <?php if(Access::isAdministrator()): ?>
            <div class="header-block">
                <h1>Добавление региона</h1>
            </div>
            <form action="http://electronicsstore/Views/Pages/Administrator/Region/" method="post">
                <div class="form-block">
                    <table class="form-block-table">
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите страну:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select name="countryId">
                                        <?php foreach ($countries as $country): ?>
                                            <option value="<?php echo $country["id"]; ?>"><?php echo $country["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Введите название региона:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <input type="text" name="name" value="">
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-button" colspan="2">
                                <input class="action-button" id="add-button" type="submit" name="action" value="Записать"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <?php VisibleError::showError(); ?>
        <?php else: ?>
            <?php Access::denyAccess(); ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>