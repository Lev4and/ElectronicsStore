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
    <title>ElectronicsStore - Единицы измерения величин</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/QuantityUnits.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/Toolbar.css">
    <link rel="stylesheet" href="/CSS/Elements/Filters.css">
    <link rel="stylesheet" href="/CSS/Elements/Table.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/QuantityUnits.js"></script>
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
                <h1>Единицы измерения величин</h1>
            </div>
            <form id="filtersForm" action="." method="post">
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Toolbar.php"; ?>
                <div style="width: 100%; display: flex; flex-direction: row; justify-content: space-between;">
                    <fieldset class="filters-block">
                        <legend>Фильтры</legend>
                        <div class="filter">
                            <span>Величины</span>
                            <div>
                                <select name="quantityId">
                                    <option value="">Выберите величину</option>
                                    <?php foreach ($quantities as $quantity): ?>
                                        <option value="<?php echo $quantity["id"]; ?>"><?php echo $quantity["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter">
                            <span>Единицы измерения</span>
                            <div>
                                <select name="unitId">
                                    <option value="">Выберите единицу измерения</option>
                                    <?php foreach ($units as $unit): ?>
                                        <option value="<?php echo $unit["id"]; ?>"><?php echo $unit["name"] . " (" . $unit["designation"] . ")"; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="reset-filters">
                            <input class="reset-filters-button" type="reset" name="action" value="Сбросить фильтры">
                        </div>
                        <div class="apply-filters">
                            <input class="apply-filters-button" type="button" onclick="onClickApply();" value="Применить">
                        </div>
                    </fieldset>
                    <div id="tableBlock">
                        <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableQuantityUnits.php"; ?>
                    </div>
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