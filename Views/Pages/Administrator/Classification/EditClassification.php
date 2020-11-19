<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ElectronicsStore - Изменение данных о классификации</title>
    <link rel="stylesheet" href="/CSS/Pages/EditClassification.css">
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
    require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Header.php";

    if(isset($_SESSION["user"]) && $_SESSION["user"]["role_name"] == "Администратор"){
        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuAdmin.php";
    }
    else{
        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuCustomer.php";
    }

    $classification = QueryExecutor::getInstance()->getClassification($_GET["classificationId"]);
    ?>
    <div class="content">
        <?php if(isset($_SESSION["user"]) && count($_SESSION["user"]) > 0 && $_SESSION["user"]["role_name"] == "Администратор"): ?>
            <div class="header-block">
                <h1>Изменение данных о классификации</h1>
            </div>
            <form action="http://electronicsstore/Views/Pages/Administrator/Classification/?classificationId=<?php echo $_GET["classificationId"]; ?>&photo=<?php echo $classification["photo"]; ?>" method="post" enctype="multipart/form-data">
                <div class="form-block">
                    <table class="form-block-table">
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-label">
                                <label>Введите название классификации:</label>
                            </td>
                            <td class="form-block-table-td-text">
                                <input type="text" name="name" value="<?php echo $classification["name"]; ?>">
                            </td>
                            <td class="form-block-table-td-image">
                                <img id="classification-photo" name="photo" src="<?php echo "http://electronicsstore/Resources/Images/Upload/" . $classification["photo"]; ?>">
                            </td>
                        </tr>
                        <tr class="form-block-table-tr">
                            <td class="form-block-table-td-button" colspan="3">
                                <script src="/JS/UnloadFile.js"></script>
                                <input class="action-button" id="add-button" type="submit" name="action" value="Сохранить"/>
                                <input id="select-file" type="file" name="selectedImage" accept="image/*" onchange="onChangeSelectedFile('select-file' , 'classification-photo');">
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Error.php"; ?>
            <?php $_SESSION["error"] = ""; ?>
        <?php else: ?>
            <?php $_SESSION["error"] = "У вас нет прав доступа на посещение данной страницы."; ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Error.php"; ?>
            <?php $_SESSION["error"] = ""; ?>
        <?php endif; ?>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Footer.php"; ?>
</div>
</body>
</html>