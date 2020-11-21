<?php
session_start();

require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$category = QueryExecutor::getInstance()->getCategory($_GET["categoryId"]);
$classifications = QueryExecutor::getInstance()->getClassifications("");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о категории</title>
    <link rel="stylesheet" href="/CSS/Pages/EditCategory.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
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
        <?php if(Access::isAdministrator()): ?>
            <div class="header-block">
                <h1>Изменение данных о категории</h1>
            </div>
            <form action="http://electronicsstore/Views/Pages/Administrator/Category/?categoryId=<?php echo $_GET["categoryId"]; ?>&photo=<?php echo $category["photo"]; ?>" method="post" enctype="multipart/form-data">
                <div class="form-block">
                    <table class="form-block-table">
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Укажите классификацию:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <select id="select-classifications" name="classificationId">
                                        <option value="">Выберите классификацию</option>
                                        <?php foreach ($classifications as $classification): ?>
                                            <option value="<?php echo $classification["id"]; ?>" <?php echo $classification["id"] == $category["classification_id"] ? 'selected="selected"' : ""; ?>><?php echo $classification["name"]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td class="form-block-table-td-image" rowspan="2">
                                <img id="category-photo" name="photo">
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Введите название категории:</label>
                            </td>
                            <td class="form-block-table-td-field">
                                <div>
                                    <input type="text" name="name" value="<?php echo $category["name"]; ?>">
                                </div>
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-button" colspan="3">
                                <script src="/JS/UnloadFile.js"></script>
                                <input class="action-button" id="add-button" type="submit" name="action" value="Сохранить"/>
                                <input id="select-file" type="file" name="selectedImage" accept="image/*" onchange="onChangeSelectedFile('select-file' , 'category-photo');">
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <?php VisibleError::showError(); ?>
        <?php else: ?>
            <?php Access::denyAccess(); ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>