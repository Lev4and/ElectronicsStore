<div class="form-block-row">
    <div id="form-block-row-column-label" class="form-block-row-column">
        <div class="form-block-row-column-label">
            <label style="text-align: left"><input type="hidden" name="characteristics[<?php echo $characteristic["characteristic_id"];  ?>]"/><?php echo $characteristic["characteristic_name"]; ?></label>
        </div>
    </div>
    <div id="form-block-row-column-input" class="form-block-row-column">
        <div class="form-block-row-column-input-select">
            <select id="characteristic-quantity-unit-values" name="characteristics[<?php echo $characteristic["characteristic_id"];  ?>][characteristicQuantityUnitValueId]">
                <option value="">Выберите значение характеристики</option>
                <?php foreach (QueryExecutor::getInstance()->getCharacteristicQuantityUnitValues($characteristic["characteristic_id"], null, null, "") as $value): ?>
                    <option value="<?php echo $value["id"]; ?>"><?php echo "{$value["value"]} {$value["unit_designation"]}"; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>