<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$warehouse = QueryExecutor::getInstance()->getWarehouse($_GET["warehouseId"]);

$countries = QueryExecutor::getInstance()->getCountries("");
$regions = QueryExecutor::getInstance()->getRegions($warehouse["country_id"], "");
$cities = QueryExecutor::getInstance()->getCities(null, $warehouse["region_id"], "");
$streets = QueryExecutor::getInstance()->getStreets(null, null, $warehouse["city_id"], "");
$houses = QueryExecutor::getInstance()->getHouses(null, null, null, $warehouse["street_id"], "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о складе</title>
    <link rel="stylesheet" href="/CSS/Pages/EditWarehouse.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/Warehouses.js"></script>
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
                <h1>Изменение данных о складе</h1>
            </div>
            <form action="http://electronicsstore/Views/Pages/Administrator/Warehouse/?warehouseId=<?php echo $_GET["warehouseId"]; ?>" method="post">
                <div class="form-block">
                    <table class="form-block-table">
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите страну:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-countries" name="countryId" onchange="onChangeSelectedCountries(this);">
                                        <option value="">Выберите страну</option>
                                        <?php foreach ($countries as $country): ?>
                                            <option value="<?php echo $country["id"]; ?>" <?php echo $country["id"] == $warehouse["country_id"] ? 'selected="selected"' : ""; ?>><?php echo $country["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите регион:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-regions" name="regionId" onchange="onChangeSelectedRegions(this);">
                                        <option value="">Выберите регион</option>
                                        <?php foreach ($regions as $region): ?>
                                            <option value="<?php echo $region["id"]; ?>" <?php echo $region["id"] == $warehouse["region_id"] ? 'selected="selected"' : ""; ?>><?php echo $region["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите город:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-cities" name="cityId" onchange="onChangeSelectedCities(this);">
                                        <option value="">Выберите город</option>
                                        <?php foreach ($cities as $city): ?>
                                            <option value="<?php echo $city["id"]; ?>" <?php echo $city["id"] == $warehouse["city_id"] ? 'selected="selected"' : ""; ?>><?php echo $city["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите улицу:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-streets" name="streetId" onchange="onChangeSelectedStreets(this);">
                                        <option value="">Выберите улицу</option>
                                        <?php foreach ($streets as $street): ?>
                                            <option value="<?php echo $street["id"]; ?>" <?php echo $street["id"] == $warehouse["street_id"] ? 'selected="selected"' : ""; ?>><?php echo $street["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите дом:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-houses" name="houseId">
                                        <option value="">Выберите дом</option>
                                        <?php foreach ($houses as $house): ?>
                                            <option value="<?php echo $house["id"]; ?>" <?php echo $house["id"] == $warehouse["street_id"] ? 'selected="selected"' : ""; ?>><?php echo $house["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Введите номер телефона:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <input type="text" name="phoneNumber" value="<?php echo $warehouse["phone_number"]; ?>">
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-button" colspan="2">
                                <input class="action-button" id="add-button" type="submit" name="action" value="Сохранить"/>
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