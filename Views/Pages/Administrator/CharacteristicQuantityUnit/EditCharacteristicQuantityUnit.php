<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$characteristicQuantityUnit = QueryExecutor::getInstance()->getCharacteristicQuantityUnit($_GET["characteristicQuantityUnitId"]);

$characteristics = QueryExecutor::getInstance()->getCharacteristics("");
$quantityUnits = QueryExecutor::getInstance()->getQuantityUnits(null, null, "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о величине и единицы измерения характеристики</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/EditCharacteristicQuantityUnit.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/BreadcrumbList.css">
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
        <?php if(Access::isAdministrator()): ?>
            <div class="breadcrumb-list">
                <ul>
                    <li><a href="../../Main.php"><span>Меню администратора > </span></a></li>
                    <li><a href="../CharacteristicQuantityUnit/"><span>Сущность БД: Величины и единицы измерения характеристик</span></a></li>
                </ul>
            </div>
            <div class="header-block">
                <h1>Изменение данных о величине и единицы измерения характеристики</h1>
            </div>
            <div class="form-block">
                <form action=".?characteristicQuantityUnitId=<?php echo $_GET["characteristicQuantityUnitId"]; ?>" method="post">
                    <div class="form-block-inputs">
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите характеристику:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select id="select-characteristics" name="characteristicId">
                                        <option value="">Выберите характеристику</option>
                                        <?php foreach ($characteristics as $characteristic): ?>
                                            <option value="<?php echo $characteristic["id"]; ?>" <?php echo $characteristic["id"] == $characteristicQuantityUnit["characteristic_id"] ? 'selected="selected"' : ""; ?>><?php echo $characteristic["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите единицу измерения величины:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select name="quantityUnitId">
                                        <option value="">Выберите единицу измерения величины</option>
                                        <?php foreach ($quantityUnits as $quantityUnit): ?>
                                            <option value="<?php echo $quantityUnit["id"]; ?>" <?php echo $quantityUnit["id"] == $characteristicQuantityUnit["quantity_unit_id"] ? 'selected="selected"' : ""; ?>><?php echo $quantityUnit["quantity_name"] . " - (" . $quantityUnit["unit_name"] . " (" . $quantityUnit["unit_designation"] . "))"; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-block-actions">
                        <div class="form-block-actions-button">
                            <input class="action-button" id="add-button" type="submit" name="action" value="Сохранить"/>
                        </div>
                    </div>
                </form>
            </div>
            <?php VisibleError::showError(); ?>
        <?php else: ?>
            <?php Access::denyAccess(); ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>