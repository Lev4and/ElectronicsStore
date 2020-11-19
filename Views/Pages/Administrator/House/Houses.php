<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Дома</title>
    <link rel="stylesheet" href="/CSS/Pages/Houses.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/Toolbar.css">
    <link rel="stylesheet" href="/CSS/Elements/TableHouses.css">
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

    if(isset($_SESSION["user"]) && $_SESSION["user"]["role_name"] == "Администратор"){
        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuAdmin.php";
    }
    else{
        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuCustomer.php";
    }
    ?>
    <div class="content">
        <?php if(isset($_SESSION["user"]) && count($_SESSION["user"]) > 0 && $_SESSION["user"]["role_name"] == "Администратор"): ?>
            <div class="header-block">
                <h1>Дома</h1>
            </div>
            <form action="http://electronicsstore/Views/Pages/Administrator/House/" method="post">
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Toolbar.php"; ?>
                <fieldset class="filters-block">
                    <legend>Фильтры</legend>
                    <div class="filter">
                        <span>Страны</span>
                        <div>
                            <select id="select-countries" name="countryId" onchange="onChangeSelectedCountries(this);">
                                <option value="">Выберите страну</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo $country["id"]; ?>"><?php echo $country["name"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="filter">
                        <span>Регионы</span>
                        <div>
                            <select id="select-regions" name="regionId" onchange="onChangeSelectedRegions(this);">

                            </select>
                        </div>
                    </div>
                    <div class="filter">
                        <span>Города</span>
                        <div>
                            <select id="select-cities" name="cityId" onchange="onChangeSelectedCities(this);">

                            </select>
                        </div>
                    </div>
                    <div class="filter">
                        <span>Улицы</span>
                        <div>
                            <select id="select-streets" name="streetId">

                            </select>
                        </div>
                    </div>
                    <div class="reset-filters">
                        <input class="reset-filters-button" type="submit" name="action" value="Сбросить фильтры">
                    </div>
                </fieldset>
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableHouses.php"; ?>
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