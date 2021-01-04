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
        <?php if(!Access::isAdministrator()): ?>
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
            <div class="header-block">
                <h1>Вы недавно смотрели</h1>
            </div>
            <div class="items-block">
                <?php if(Access::isAuthorized()): ?>
                    <?php foreach (QueryExecutor::getInstance()->getViewedProductsUser($_SESSION["user"]["id"]) as $product): ?>
                        <div class="item-block">
                            <a href="/Views/Pages/Customer/Catalog/Product.php?productId=<?php echo $product["product_id"]; ?>">
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
                <?php else: ?>
                    <?php foreach (QueryExecutor::getInstance()->getViewedProductsStrangerUser($_COOKIE["viewedProducts"]) as $product): ?>
                        <div class="item-block">
                            <a href="/Views/Pages/Customer/Catalog/Product.php?productId=<?php echo $product["product_id"]; ?>">
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
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="header-block">
                <h1>Меню администратора</h1>
            </div>
            <div class="sections-block">
                <ul>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Country/">Сущность БД: Страны</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Region/">Сущность БД: Регионы</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/City/">Сущность БД: Города</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Street/">Сущность БД: Улицы</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/House/">Сущность БД: Дома</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Classification/">Сущность БД: Классификации</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Category/">Сущность БД: Категории</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Subcategory/">Сущность БД: Подкатегории</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/CategorySubcategory/">Сущность БД: Категории подкатегорий</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Manufacturer/">Сущность БД: Производители</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Characteristic/">Сущность БД: Характеристики</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Section/">Сущность БД: Разделы характеристик</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/SectionCategorySubcategory/">Сущность БД: Разделы характеристик категории подкатегорий</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/CharacteristicCategorySubcategory/">Сущность БД: Характеристики категории подкатегорий</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/CharacteristicQuantityUnitValue/">Сущность БД: Значения характеристик</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Quantity/">Сущность БД: Величины</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Unit/">Сущность БД: Единицы измерения</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/QuantityUnit/">Сущность БД: Единицы измерения величин</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/CharacteristicQuantityUnit/">Сущность БД: Величины и единицы измерения характеристик</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/EvaluationCriterion/">Сущность БД: Критерии оценивания</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/EvaluationCriterionCategorySubcategory/">Сущность БД: Критерии оценивания категории подкатегорий</a></span></li>
                    <li><span class="sections-block-title-section"><a href="../../Views/Pages/Administrator/Product/">Сущность БД: Товары</a></span></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>