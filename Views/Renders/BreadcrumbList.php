<?php if(isset($_GET["classificationId"])): ?>
    <?php $classification = QueryExecutor::getInstance()->getClassification($_GET["classificationId"]); ?>
    <div class="breadcrumb-list">
        <ul>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Каталог"; ?>"><span>Каталог</span></a></li>
        </ul>
    </div>
<?php endif; ?>

<?php if(isset($_GET["categoryId"])): ?>
    <?php $category = QueryExecutor::getInstance()->getCategory($_GET["categoryId"]); ?>
    <div class="breadcrumb-list">
        <ul>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Каталог"; ?>"><span>Каталог > </span></a></li>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Категории&classificationId={$category["classification_id"]}"; ?>"><span><?php echo $category["classification_name"]; ?></span></a></li>
        </ul>
    </div>
<?php endif; ?>

<?php if(isset($_GET["subcategoryId"])): ?>
    <?php $subcategory = QueryExecutor::getInstance()->getSubcategory($_GET["subcategoryId"]); ?>
    <div class="breadcrumb-list">
        <ul>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Каталог"; ?>"><span>Каталог > </span></a></li>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Категории&classificationId={$subcategory["classification_id"]}"; ?>"><span><?php echo $subcategory["classification_name"]; ?> ></span></a></li>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Подкатегории&categoryId={$subcategory["category_id"]}"; ?>"><span><?php echo $subcategory["category_name"]; ?></span></a></li>
        </ul>
    </div>
<?php endif; ?>

<?php if(isset($_GET["categorySubcategoryId"])): ?>
    <?php $categorySubcategory = QueryExecutor::getInstance()->getCategorySubcategory($_GET["categorySubcategoryId"]); ?>
    <div class="breadcrumb-list">
        <ul>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Каталог"; ?>"><span>Каталог > </span></a></li>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Категории&classificationId={$categorySubcategory["classification_id"]}"; ?>"><span><?php echo $categorySubcategory["classification_name"]; ?> ></span></a></li>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Подкатегории&categoryId={$categorySubcategory["category_id"]}"; ?>"><span><?php echo $categorySubcategory["category_name"]; ?> ></span></a></li>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=КатегорииПодкатегории&subcategoryId={$categorySubcategory["subcategory_id"]}"; ?>"><span><?php echo $categorySubcategory["subcategory_name"]; ?></span></a></li>
        </ul>
    </div>
<?php endif; ?>

<?php if(isset($_GET["productId"])): ?>
    <?php $product = QueryExecutor::getInstance()->getProduct($_GET["productId"]); ?>
    <div class="breadcrumb-list">
        <ul>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Каталог"; ?>"><span>Каталог > </span></a></li>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Категории&classificationId={$product["classification_id"]}"; ?>"><span><?php echo $product["classification_name"]; ?> ></span></a></li>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Подкатегории&categoryId={$product["category_id"]}"; ?>"><span><?php echo $product["category_name"]; ?> ></span></a></li>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=КатегорииПодкатегории&subcategoryId={$product["subcategory_id"]}"; ?>"><span><?php echo $product["subcategory_name"]; ?> ></span></a></li>
            <li><a href="<?php echo "http://{$_SERVER["SERVER_NAME"]}/Views/Pages/Customer/Catalog/?action=Товары&categorySubcategoryId={$product["category_subcategory_id"]}"; ?>"><span><?php echo $product["category_subcategory_name"]; ?></span></a></li>
        </ul>
    </div>
<?php endif; ?>
