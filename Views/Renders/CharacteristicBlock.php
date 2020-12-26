<div class="form-block-characteristic-row" style="margin: 10px 0; border-top: solid black 1px; border-bottom: solid black 1px;">
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
    <div class="form-block-row">
        <div id="form-block-characteristic-row-column-input-checkbox" class="form-block-row-column" style="width: 100%; max-width: 100%">
            <div  class="form-block-row-column-input-checkbox" style="width: 100%; height: 100%; display: flex; flex-direction: row; justify-content: center">
                <div style="margin: auto">
                    <input type="checkbox" name="characteristics[<?php echo $characteristic["characteristic_id"];  ?>][newCharacteristicQuantityUnitValue][whetherToAdd]" style="margin: auto; width: auto; height: auto;">
                    <span style="margin: auto; max-height: 100%; text-align: left;">Новое значение</span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-block-row">
        <div id="form-block-characteristic-row-column-input" class="form-block-row-column" style="display: flex; flex-direction: row; justify-content: flex-start">
            <div class="form-block-row-column-input-text" style="width: 95%">
                <input type="text" name="characteristics[<?php echo $characteristic["characteristic_id"];  ?>][newCharacteristicQuantityUnitValue][value]" placeholder="Новое значение">
            </div>
        </div>
        <div id="form-block-row-column-input" class="form-block-row-column" style="display: flex; flex-direction: row; justify-content: flex-end">
            <div class="form-block-row-column-input-select" style="width: 95%">
                <select name="characteristics[<?php echo $characteristic["characteristic_id"];  ?>][newCharacteristicQuantityUnitValue][quantityUnitId]">
                    <option value="">Выберите единицу измерения величины</option>
                    <?php foreach (QueryExecutor::getInstance()->getCharacteristicQuantityUnits($characteristic["characteristic_id"], null, null, "") as $characteristicQuantityUnit): ?>
                        <option value="<?php echo $characteristicQuantityUnit["quantity_unit_id"]; ?>"><?php echo $characteristicQuantityUnit["quantity_name"] . " - (" . $characteristicQuantityUnit["unit_name"] . " (" . $characteristicQuantityUnit["unit_designation"] . "))"; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>