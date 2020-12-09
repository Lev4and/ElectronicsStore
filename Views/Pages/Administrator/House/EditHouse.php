<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$house = QueryExecutor::getInstance()->getHouse($_GET["houseId"]);

$countries = QueryExecutor::getInstance()->getCountries("");
$regions = QueryExecutor::getInstance()->getRegions($house["country_id"], "");
$cities = QueryExecutor::getInstance()->getCities(null, $house["region_id"], "");
$streets = QueryExecutor::getInstance()->getStreets(null, null, $house["street_id"], "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о доме</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/EditHouse.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/Form.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <script src="/JS/JQuery.js"></script>
    <script src="/JS/Houses.js"></script>
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
                <h1>Изменение данных о доме</h1>
            </div>
            <div class="form-block">
                <form action="http://electronicsstore/Views/Pages/Administrator/House/" method="post">
                    <div class="form-block-inputs">
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите страну:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select id="select-countries" name="countryId" onchange="onChangeSelectedCountries(this);">
                                        <option value="">Выберите страну</option>
                                        <?php foreach ($countries as $country): ?>
                                            <option value="<?php echo $country["id"]; ?>" <?php echo $country["id"] == $house["country_id"] ? 'selected="selected"' : ""; ?>><?php echo $country["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите регион:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select id="select-regions" name="regionId" onchange="onChangeSelectedRegions(this)">
                                        <option value="">Выберите регион</option>
                                        <?php foreach ($regions as $region): ?>
                                            <option value="<?php echo $region["id"]; ?>" <?php echo $region["id"] == $house["region_id"] ? 'selected="selected"' : ""; ?>><?php echo $region["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите город:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select id="select-cities" name="cityId" onchange="onChangeSelectedCities(this);">
                                        <option value="">Выберите город</option>
                                        <?php foreach ($cities as $city): ?>
                                            <option value="<?php echo $city["id"]; ?>" <?php echo $city["id"] == $house["city_id"] ? 'selected="selected"' : ""; ?>><?php echo $city["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Укажите улицу:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-select">
                                    <select id="select-streets" name="streetId">
                                        <option value="">Выберите улицу</option>
                                        <?php foreach ($streets as $street): ?>
                                            <option value="<?php echo $street["id"]; ?>" <?php echo $street["id"] == $house["street_id"] ? 'selected="selected"' : ""; ?>><?php echo $street["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Введите название дома:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-text">
                                    <input type="text" name="name" value="<?php echo $house["name"]; ?>">
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