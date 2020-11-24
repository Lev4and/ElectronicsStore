<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$selectedClassification = QueryExecutor::getInstance()->getClassification($_GET["classificationId"]);
$categoriesClassification = QueryExecutor::getInstance()->getCategories($_GET["classificationId"], "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - <?php echo $selectedClassification["name"]; ?></title>
    <link rel="stylesheet" href="/CSS/Pages/CatalogCategories.css">
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
        <?php if(!Access::isAdministrator()): ?>
            <div class="header-block">
                <h1><?php echo $selectedClassification["name"]; ?></h1>
            </div>
            <div class="categories-block">
                <?php foreach ($categoriesClassification as $category): ?>
                    <div class="category-block">
                        <a href="/Views/Pages/Customer/Catalog/?action=Подкатегории&categoryId=<?php echo $category["id"]; ?>">
                            <div>
                                <div class="category-block-image-container">
                                    <img src="<?php echo "/Resources/Images/Upload/" . $category["photo"]; ?>">
                                </div>
                                <div class="category-block-title">
                                    <span><?php echo $category["name"]; ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
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