<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$characteristic = QueryExecutor::getInstance()->getCharacteristic($_GET["characteristicId"]);
$characteristicQuantityUnits = QueryExecutor::getInstance()->getCharacteristicQuantityUnits($_GET["characteristicId"], null, null, "");

function containsCharacteristicQuantityUnit($quantityUnitId){
    foreach ($GLOBALS["characteristicQuantityUnits"] as $characteristicQuantityUnit){
        if($characteristicQuantityUnit["quantity_unit_id"] == $quantityUnitId){
            return true;
        }
    }

    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о характеристики</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/EditCharacteristic.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
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
            <div class="header-block">
                <h1>Изменение данных о характеристики</h1>
            </div>
            <div class="form-block">
                <form action=".?characteristicId=<?php echo $_GET["characteristicId"]; ?>&countQuantityUnits=<?php echo count($characteristicQuantityUnits); ?>" method="post">
                    <div class="form-block-inputs">
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Введите название характеристики:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-text">
                                    <input type="text" name="name" value="<?php echo $characteristic["name"]; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите величины и единицы измерения характеристики:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-checkbox-list-block" class="form-block-row-column">
                                <div class="form-block-row-column-checkbox-list">
                                    <ul>
                                        <?php foreach (QueryExecutor::getInstance()->getQuantityUnits(null, null, "") as $quantityUnit): ?>
                                            <li><input type="checkbox" name="quantityUnits[]" value="<?php echo $quantityUnit["id"]; ?>" <?php echo containsCharacteristicQuantityUnit($quantityUnit["id"]) ? "checked='checked'" : ""; ?>><span><?php echo "{$quantityUnit["quantity_name"]} - ({$quantityUnit["unit_name"]} ({$quantityUnit["unit_designation"]}))";; ?></span></li>
                                        <?php endforeach; ?>
                                    </ul>
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