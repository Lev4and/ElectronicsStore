<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/VisibleError.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Logic/Managers/Access.php";

$classification = QueryExecutor::getInstance()->getClassification($_GET["classificationId"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о классификации</title>
    <link rel="stylesheet" href="/CSS/Pages/Main.css">
    <link rel="stylesheet" href="/CSS/Pages/EditClassification.css">
    <link rel="stylesheet" href="/CSS/Elements/Header.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuUser.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuAdmin.css">
    <link rel="stylesheet" href="/CSS/Elements/MenuCustomer.css">
    <link rel="stylesheet" href="/CSS/Elements/Form.css">
    <link rel="stylesheet" href="/CSS/Elements/Error.css">
    <link rel="stylesheet" href="/CSS/Elements/Footer.css">
    <link rel="icon" href="/Resources/Images/Icons/Logo.png">
    <link rel="stylesheet" href="/Resources/Fonts/Font%20Awesome/css/all.min.css">
    <script src="/JS/UnloadFile.js"></script>
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
                <h1>Изменение данных о классификации</h1>
            </div>
            <div class="form-block">
                <form action="http://electronicsstore/Views/Pages/Administrator/Classification/?classificationId=<?php echo $_GET["classificationId"]; ?>&photo=<?php echo $classification["photo"]; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-block-image-block">
                        <div class="form-block-image-block-container">
                            <img id="classification-photo" name="photo" src="<?php echo "http://electronicsstore/Resources/Images/Upload/" . $classification["photo"]; ?>">
                        </div>
                    </div>
                    <div class="form-block-inputs">
                        <div class="form-block-row">
                            <div id="form-block-row-column-label" class="form-block-row-column">
                                <div class="form-block-row-column-label">
                                    <label>Введите название классификации:</label>
                                </div>
                            </div>
                            <div id="form-block-row-column-input" class="form-block-row-column">
                                <div class="form-block-row-column-input-text">
                                    <input type="text" name="name" value="<?php echo $classification["name"]; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-block-actions">
                        <div class="form-block-actions-button">
                            <input class="action-button" id="add-button" type="submit" name="action" value="Сохранить"/>
                        </div>
                        <div class="form-block-actions-select-file">
                            <input id="select-file" type="file" name="selectedImage" accept="image/*" onchange="onChangeSelectedFile('select-file' , 'classification-photo');">
                        </div>
                    </div>
                </form>
            </div>
            <?php VisibleError::showError(); ?>
        <?php else: ?>
            <?php Access::denyAccess(); ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>