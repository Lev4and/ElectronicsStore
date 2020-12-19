<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$manufacturers = QueryExecutor::getInstance()->getManufacturers("");
$products = QueryExecutor::getInstance()->getProducts(null, null, null, null, null, null, null, "", null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Магазин электроники</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/ItemBlock.css">
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
        <div class="header-block">
            <h1>Производители</h1>
        </div>
        <div class="items-block">
            <?php foreach ($manufacturers as $manufacturer): ?>
                <div class="item-block">
                    <a href="/Views/Pages/Customer/Catalog/ProductsManufacturer.php?manufacturerId=<?php echo $manufacturer["id"]; ?>">
                        <div class="item-block-container">
                            <div class="item-block-container-image-container">
                                <img src="<?php echo "http://" . $_SERVER["SERVER_NAME"] . "/Resources/Images/Upload/" . $manufacturer["photo"]; ?>">
                            </div>
                            <div class="item-block-container-title">
                                <span><?php echo $manufacturer["name"]; ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="header-block">
            <h1>Товары</h1>
        </div>
        <div class="items-block">
            <?php foreach ($products as $product): ?>
                <div class="item-block">
                    <a href="/Views/Pages/Customer/Catalog/Product.php?productId=<?php echo $product["id"]; ?>">
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
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>