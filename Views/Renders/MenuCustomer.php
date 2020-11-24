<?php
$classifications = QueryExecutor::getInstance()->getClassifications("");
$categories = QueryExecutor::getInstance()->getCategories(null, "");
$subcategories = QueryExecutor::getInstance()->getSubcategories(null, null, "");
$categoriesSubcategory = QueryExecutor::getInstance()->getCategoriesSubcategory(null, null,  null, "");
?>
<div id="menu-customer" class="menu-customer">
    <ul class="menu-customer-classifications">
        <?php foreach ($classifications as $classification): ?>
            <li class="menu-customer-classification">
                <span><a href="/Views/Pages/Customer/Catalog/?action=Категории&classificationId=<?php echo $classification["id"]; ?>"><?php echo $classification["name"]; ?></a></span>
                <ul class="menu-customer-categories">
                    <?php foreach ($categories as $category): ?>
                        <?php if($category["classification_id"] == $classification["id"]): ?>
                            <li class="menu-customer-category">
                                <span><a href="/Views/Pages/Customer/Catalog/?action=Подкатегории&categoryId=<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></a></span>
                                <ul class="menu-customer-subcategories">
                                    <?php foreach ($subcategories as $subcategory): ?>
                                        <?php if($subcategory["category_id"] == $category["id"]): ?>
                                            <li class="menu-customer-subcategory">
                                                <span><a href="/Views/Pages/Customer/Catalog/?action=КатегорииПодкатегории&subcategoryId=<?php echo $subcategory["id"]; ?>"><?php echo $subcategory["name"]; ?></a></span>
                                                <ul class="menu-customer-categories-subcategory">
                                                    <?php foreach ($categoriesSubcategory as $categorySubcategory): ?>
                                                        <?php if($categorySubcategory["subcategory_id"] == $subcategory["id"]): ?>
                                                            <li class="menu-customer-category-subcategory"><span><a href="/Views/Pages/Customer/Catalog/?action=Товары&categorySubcategoryId=<?php echo $categorySubcategory["id"]; ?>"><?php echo $categorySubcategory["name"]; ?></a></span></li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
</div>