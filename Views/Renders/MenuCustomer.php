<?php
$classifications = QueryExecutor::getInstance()->getClassifications("");
$categories = QueryExecutor::getInstance()->getCategories(null, "");
$subcategories = QueryExecutor::getInstance()->getSubcategories(null, null, "");
?>
<div id="menu-customer" class="menu-customer">
    <ul class="menu-customer-classifications">
        <?php foreach ($classifications as $classification): ?>
            <li class="menu-customer-classification">
                <span><?php echo $classification["name"]; ?></span>
                <ul class="menu-customer-categories">
                    <?php foreach ($categories as $category): ?>
                        <?php if($category["classification_id"] == $classification["id"]): ?>
                            <li class="menu-customer-category">
                                <span><?php echo $category["name"]; ?></span>
                                <ul class="menu-customer-subcategories">
                                    <?php foreach ($subcategories as $subcategory): ?>
                                        <?php if($subcategory["category_id"] == $category["id"]): ?>
                                            <li class="menu-customer-subcategory"><span><?php echo $subcategory["name"]; ?></span></li>
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