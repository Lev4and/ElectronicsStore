<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$manufacturer = QueryExecutor::getInstance()->getManufacturer($_GET["manufacturerId"]);
$products = QueryExecutor::getInstance()->getProducts(null, null, null, null, $_GET["manufacturerId"], null, null, "", null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - <?php echo $manufacturer["name"]; ?></title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/ProductsManufacturer.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
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
            <div class="header-block">
                <h1><?php echo $manufacturer["name"]; ?></h1>
            </div>
            <div class="items-block">
                <?php foreach ($products as $product): ?>
                    <div class="item-block">
                        <a href="Product.php?productId=<?php echo $product["id"]; ?>">
                            <div class="item-block-container">
                                <div class="item-block-container-image-container">
                                    <img src="<?php echo "http://" . $_SERVER["SERVER_NAME"] . "/Resources/Images/Upload/" . $product["photo"]; ?>">
                                </div>
                                <div class="item-block-container-title">
                                    <span><?php echo $product["name"]; ?></span>
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