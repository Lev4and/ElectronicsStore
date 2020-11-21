<div class="categories">
    <table class="table-categories" border="1">
        <tr class="table-categories-row-headers">
            <th id="select" class="select">Выбрать</th>
            <th id="category-photo" class="category-photo">Фото</th>
            <th id="classification-name" class="classification-name">Классификация</th>
            <th id="category-name" class="classification-name">Название</th>
        </tr>
        <?php foreach ($categories as $category): ?>
            <tr id="<?php echo $category["id"]; ?>" class="table-categories-row-values">
                <td id="select" class="select"><input type="radio" name="selectedCategory" checked="checked" value="<?php echo $category["id"]; ?>"></td>
                <td id="category-photo" class="category-photo"><img src="/Resources/Images/Upload/<?php echo $category["photo"]; ?>"></td>
                <td id="classification-name" class="classification-name"><?php echo $category["classification_name"]; ?></td>
                <td id="category-name" class="category-name"><?php echo $category["name"]; ?></td>
            </tr>
        <? endforeach; ?>
    </table>
</div>