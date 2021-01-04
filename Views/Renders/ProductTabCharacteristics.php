<div class="product-block-tab-content-characteristics">
    <?php foreach ($sectionsCategorySubcategoryProduct as $sectionCategorySubcategoryProduct): ?>
        <div class="characteristics-sections-block">
            <div class="characteristics-section-block">
                <div class="characteristics-section-title-block">
                    <span><?php echo $sectionCategorySubcategoryProduct["section_name"]; ?></span>
                </div>
            </div>
            <div class="section-characteristic-block">
                <?php foreach ($productCharacteristicsQuantityUnitValuesDetailedInformation as $characteristicsQuantityUnitValue): ?>
                    <?php if($characteristicsQuantityUnitValue["section_category_subcategory_id"] == $sectionCategorySubcategoryProduct["section_category_subcategory_id"]): ?>
                        <div class="characteristic-block">
                            <div class="characteristic-block-title-block">
                                <span><?php echo $characteristicsQuantityUnitValue["characteristic_name"]; ?></span>
                            </div>
                            <div class="characteristic-block-value-block">
                                <span><?php echo "{$characteristicsQuantityUnitValue["value"]} {$characteristicsQuantityUnitValue["unit_designation"]}"; ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>