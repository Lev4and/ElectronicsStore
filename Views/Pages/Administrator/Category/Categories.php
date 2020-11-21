<?php
session_start();

require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Категории</title>
    <link rel="stylesheet" href="/CSS/Pages/Categories.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/Toolbar.css">
    <link rel="stylesheet" href="/CSS/Elements/TableCategories.css">
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
                <h1>Категории</h1>
            </div>
            <form action="http://electronicsstore/Views/Pages/Administrator/Category/" method="post">
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Toolbar.php"; ?>
                <fieldset class="filters-block">
                    <legend>Фильтры</legend>
                    <div class="filter">
                        <span>Классификации</span>
                        <div>
                            <select id="select-classifications" name="classificationId">
                                <option value="">Выберите классификацию</option>
                                <?php foreach ($classifications as $classification): ?>
                                    <option value="<?php echo $classification["id"]; ?>"><?php echo $classification["name"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="reset-filters">
                        <input class="reset-filters-button" type="submit" name="action" value="Сбросить фильтры">
                    </div>
                </fieldset>
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableCategories.php"; ?>
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