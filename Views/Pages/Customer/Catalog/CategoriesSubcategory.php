<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$selectedSubcategory = QueryExecutor::getInstance()->getSubcategory($_GET["subcategoryId"]);
$categoriesSubcategory = QueryExecutor::getInstance()->getCategoriesSubcategory(null, null, $_GET["subcategoryId"], "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - <?php echo $selectedSubcategory["name"]; ?></title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/CatalogCategoriesSubcategory.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/BreadcrumbList.css">
    <link rel="stylesheet" href="/CSS/Elements/ItemBlock.css">
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
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/BreadcrumbList.php"; ?>
            <div class="items-block">
                <?php foreach ($categoriesSubcategory as $categorySubcategory): ?>
                    <div class="item-block">
                        <a href=".?action=Товары&categorySubcategoryId=<?php echo $categorySubcategory["id"]; ?>">
                            <div class="item-block-container">
                                <div class="item-block-container-image-container">
                                    <img src="<?php echo "http://" . $_SERVER["SERVER_NAME"] . "/Resources/Images/Upload/" . $categorySubcategory["photo"]; ?>">
                                </div>
                                <div class="item-block-container-title">
                                    <span><?php echo $categorySubcategory["name"]; ?></span>
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