<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о доме</title>
    <link rel="stylesheet" href="/CSS/Pages/EditHouse.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
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
    require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";

    if(isset($_SESSION["user"]) && $_SESSION["user"]["role_name"] == "Администратор"){
        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuAdmin.php";
    }
    else{
        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuCustomer.php";
    }

    $house = QueryExecutor::getInstance()->getHouse($_GET["houseId"]);

    $countries = QueryExecutor::getInstance()->getCountries("");
    $regions = QueryExecutor::getInstance()->getRegions($house["country_id"], "");
    $cities = QueryExecutor::getInstance()->getCities(null, $house["region_id"], "");
    $streets = QueryExecutor::getInstance()->getStreets(null, null, $house["street_id"], "");
    ?>
    <div class="content">
        <?php if(isset($_SESSION["user"]) && count($_SESSION["user"]) > 0 && $_SESSION["user"]["role_name"] == "Администратор"): ?>
            <div class="header-block">
                <h1>Изменение данных о доме</h1>
            </div>
            <form action="http://electronicsstore/Views/Pages/Administrator/House/?houseId=<?php echo $_GET["houseId"]; ?>" method="post">
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
                                            <option value="<?php echo $country["id"]; ?>" <?php echo $country["id"] == $house["country_id"] ? 'selected="selected"' : ""; ?>><?php echo $country["name"]; ?></option>
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
                                    <select id="select-regions" name="regionId" onchange="onChangeSelectedRegions(this)">
                                        <option value="">Выберите регион</option>
                                        <?php foreach ($regions as $region): ?>
                                            <option value="<?php echo $region["id"]; ?>" <?php echo $region["id"] == $house["region_id"] ? 'selected="selected"' : ""; ?>><?php echo $region["name"]; ?></option>
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
                                            <option value="<?php echo $city["id"]; ?>" <?php echo $city["id"] == $house["city_id"] ? 'selected="selected"' : ""; ?>><?php echo $city["name"]; ?></option>
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
                                    <select id="select-streets" name="streetId">
                                        <option value="">Выберите улицу</option>
                                        <?php foreach ($streets as $street): ?>
                                            <option value="<?php echo $street["id"]; ?>" <?php echo $street["id"] == $house["street_id"] ? 'selected="selected"' : ""; ?>><?php echo $street["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Введите название дома:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <input type="text" name="name" value="<?php echo $house["name"]; ?>">
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
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Error.php"; ?>
            <?php $_SESSION["error"] = ""; ?>
        <?php else: ?>
            <?php $_SESSION["error"] = "У вас нет прав доступа на посещение данной страницы."; ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Error.php"; ?>
            <?php $_SESSION["error"] = ""; ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>