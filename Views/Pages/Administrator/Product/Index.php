<?php
session_start();

require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

$products = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddProduct.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditProduct.php?productId=" . $_POST["selectedProduct"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeProduct($_POST["selectedProduct"]);

    $products = QueryExecutor::getInstance()->getProducts($_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["manufacturerId"], null, null, $_POST["inputSearch"]);

    include "Products.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Категории"){
    if(isset($_POST["classificationId"]) && $_POST["classificationId"] > 0){
        echo '<option value="">Выберите категорию</option>';
        foreach (QueryExecutor::getInstance()->getCategories($_POST["classificationId"], "") as $category){
            echo '<option value="' .$category["id"] . '">' . $category["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите категорию</option>';
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Подкатегории"){
    if(isset($_POST["categoryId"]) && $_POST["categoryId"] > 0){
        echo '<option value="">Выберите подкатегорию</option>';
        foreach (QueryExecutor::getInstance()->getSubcategories(null, $_POST["categoryId"], "") as $subcategory){
            echo '<option value="' .$subcategory["id"] . '">' . $subcategory["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите подкатегорию</option>';
    }
}


if(isset($_POST["action"]) && $_POST["action"] == "КатегорииПодкатегории"){
    if(isset($_POST["subcategoryId"]) && $_POST["subcategoryId"] > 0){
        echo '<option value="">Выберите категорию подкатегории</option>';
        foreach (QueryExecutor::getInstance()->getCategoriesSubcategory(null, null, $_POST["subcategoryId"], "") as $categorySubcategory){
            echo '<option value="' .$categorySubcategory["id"] . '">' . $categorySubcategory["name"] . '</option>';
        }
    }
    else{
        echo '<option value="">Выберите категорию подкатегории</option>';
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Характеристики"){
    if(isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0){
        foreach (QueryExecutor::getInstance()->getCharacteristicsCategorySubcategory(null, null, null, null, $_POST["categorySubcategoryId"], null, null, null, "") as $characteristic){
            include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/CharacteristicBlock.php";
        }
    }
    else{
        echo "";
    }
}

if(isset($_POST) && $_POST["action"] == "Содержимое вкладки"){
    if(isset($_POST["productId"]) && $_POST["productId"] > 0){
        switch ($_POST["tabName"]){
            case "Описание":
                $product = QueryExecutor::getInstance()->getProduct($_POST["productId"]);

                include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/ProductTabDescription.php";
                break;
            case "Характеристики":
                $product = QueryExecutor::getInstance()->getProduct($_POST["productId"]);
                $sectionsCategorySubcategoryProduct = QueryExecutor::getInstance()->getSectionsCategorySubcategoryProduct($_POST["productId"]);
                $productCharacteristicsQuantityUnitValuesDetailedInformation = QueryExecutor::getInstance()->getProductCharacteristicsQuantityUnitValuesDetailedInformation($_POST["productId"]);

                include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/ProductTabCharacteristics.php";
                break;
            case "Отзывы":
                break;
        }
    }

    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if(isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0 && isset($_POST["manufacturerId"]) && $_POST["manufacturerId"] > 0 && isset($_POST["model"]) && iconv_strlen($_POST["model"], "UTF-8") > 0 && isset($_POST["price"]) && $_POST["price"] > 0){
        if(!QueryExecutor::getInstance()->containsProduct($_POST["manufacturerId"], $_POST["model"])){
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            $productId = QueryExecutor::getInstance()->addProduct($_POST["categorySubcategoryId"], $_POST["manufacturerId"], $fileName, $_POST["model"], $_POST["description"], $_POST["price"]);

            foreach ($_POST["characteristics"] as $key => $value){
                if((isset($value["characteristicQuantityUnitValueId"]) && $value["characteristicQuantityUnitValueId"] > 0) || $value["newCharacteristicQuantityUnitValue"]["whetherToAdd"]){
                    //echo "Ключ: {$key} Значение: {$value["characteristicQuantityUnitValueId"]}<br>";

                    if(isset($value["newCharacteristicQuantityUnitValue"]) && isset($value["newCharacteristicQuantityUnitValue"]["whetherToAdd"]) && $value["newCharacteristicQuantityUnitValue"]["whetherToAdd"] && iconv_strlen($value["newCharacteristicQuantityUnitValue"]["value"], "UTF-8") > 0 && $value["newCharacteristicQuantityUnitValue"]["quantityUnitId"] > 0){
                        if(!QueryExecutor::getInstance()->containsCharacteristicQuantityUnitValue($key, $value["newCharacteristicQuantityUnitValue"]["quantityUnitId"], $value["newCharacteristicQuantityUnitValue"]["value"])){
                            $characteristicQuantityUnitValueId = QueryExecutor::getInstance()->addCharacteristicQuantityUnitValue($key, $value["newCharacteristicQuantityUnitValue"]["quantityUnitId"], $value["newCharacteristicQuantityUnitValue"]["value"]);

                            QueryExecutor::getInstance()->addProductCharacteristicQuantityUnitValue($productId, $characteristicQuantityUnitValueId);
                        }
                        else{
                            $characteristicQuantityUnitValueId = QueryExecutor::getInstance()->getCharacteristicQuantityUnitValueId($key, $value["newCharacteristicQuantityUnitValue"]["quantityUnitId"], $value["newCharacteristicQuantityUnitValue"]["value"]);

                            QueryExecutor::getInstance()->addProductCharacteristicQuantityUnitValue($productId, $characteristicQuantityUnitValueId);
                        }
                    }
                    else{
                        if(isset($value["characteristicQuantityUnitValueId"]) && $value["characteristicQuantityUnitValueId"] > 0){
                            QueryExecutor::getInstance()->addProductCharacteristicQuantityUnitValue($productId, $value["characteristicQuantityUnitValueId"]);
                        }
                    }
                }
            }

            foreach ($_FILES["selectedImages"]["name"] as $key => $value){
                //echo "NAME: {$_FILES["selectedImages"]["name"][$key]} TMP_NAME: {$_FILES["selectedImages"]["tmp_name"][$key]} ";

                if(isset($_FILES["selectedImages"]["name"][$key]) && isset($_FILES["selectedImages"]["tmp_name"][$key])){
                    move_uploaded_file($_FILES["selectedImages"]["tmp_name"][$key], $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/{$_FILES["selectedImages"]["name"][$key]}");

                    QueryExecutor::getInstance()->addProductPhoto($productId, $_FILES["selectedImages"]["name"][$key]);
                }
            }

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Product/");
            exit();
        }
        else{
            $_SESSION["error"] = "Продукт с такими данными уже существует.";

            header("Location: AddProduct.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddProduct.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["categorySubcategoryId"]) && $_POST["categorySubcategoryId"] > 0 && isset($_POST["manufacturerId"]) && $_POST["manufacturerId"] > 0 && isset($_POST["model"]) && iconv_strlen($_POST["model"], "UTF-8") > 0 && isset($_POST["price"]) && $_POST["price"] > 0) {
        if ($_GET["manufacturerId"] != $_POST["manufacturerId"] || $_GET["model"] != $_POST["model"] ? !QueryExecutor::getInstance()->containsProduct($_POST["manufacturerId"], $_POST["model"]) : true) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->updateProduct($_GET["productId"], $_POST["categorySubcategoryId"], $_POST["manufacturerId"], iconv_strlen($fileName) > 0 ? $fileName : $_GET["photo"], $_POST["model"], $_POST["description"], $_POST["price"]);
            QueryExecutor::getInstance()->removeAllProductCharacteristicsQuantityUnitValues($_GET["productId"]);

            foreach ($_POST["characteristics"] as $key => $value){
                if((isset($value["characteristicQuantityUnitValueId"]) && $value["characteristicQuantityUnitValueId"] > 0) || $value["newCharacteristicQuantityUnitValue"]["whetherToAdd"]){
                    //echo "Ключ: {$key} Значение: {$value["characteristicQuantityUnitValueId"]}<br>";

                    if(isset($value["newCharacteristicQuantityUnitValue"]) && isset($value["newCharacteristicQuantityUnitValue"]["whetherToAdd"]) && $value["newCharacteristicQuantityUnitValue"]["whetherToAdd"] && iconv_strlen($value["newCharacteristicQuantityUnitValue"]["value"], "UTF-8") > 0 && $value["newCharacteristicQuantityUnitValue"]["quantityUnitId"] > 0){
                        if(!QueryExecutor::getInstance()->containsCharacteristicQuantityUnitValue($key, $value["newCharacteristicQuantityUnitValue"]["quantityUnitId"], $value["newCharacteristicQuantityUnitValue"]["value"])){
                            $characteristicQuantityUnitValueId = QueryExecutor::getInstance()->addCharacteristicQuantityUnitValue($key, $value["newCharacteristicQuantityUnitValue"]["quantityUnitId"], $value["newCharacteristicQuantityUnitValue"]["value"]);

                            QueryExecutor::getInstance()->addProductCharacteristicQuantityUnitValue($_GET["productId"], $characteristicQuantityUnitValueId);
                        }
                        else{
                            $characteristicQuantityUnitValueId = QueryExecutor::getInstance()->getCharacteristicQuantityUnitValueId($key, $value["newCharacteristicQuantityUnitValue"]["quantityUnitId"], $value["newCharacteristicQuantityUnitValue"]["value"]);

                            QueryExecutor::getInstance()->addProductCharacteristicQuantityUnitValue($_GET["productId"], $characteristicQuantityUnitValueId);
                        }
                    }
                    else{
                        if(isset($value["characteristicQuantityUnitValueId"]) && $value["characteristicQuantityUnitValueId"] > 0){
                            QueryExecutor::getInstance()->addProductCharacteristicQuantityUnitValue($_GET["productId"], $value["characteristicQuantityUnitValueId"]);
                        }
                    }
                }
            }

            if(isset($_FILES["selectedImages"]["name"]) && count($_FILES["selectedImages"]["name"]) > 0){
                QueryExecutor::getInstance()->removeAllProductPhoto($_GET["productId"]);

                foreach ($_FILES["selectedImages"]["name"] as $key => $value){
                    //echo "NAME: {$_FILES["selectedImages"]["name"][$key]} TMP_NAME: {$_FILES["selectedImages"]["tmp_name"][$key]} ";

                    if(isset($_FILES["selectedImages"]["name"][$key]) && isset($_FILES["selectedImages"]["tmp_name"][$key])){
                        move_uploaded_file($_FILES["selectedImages"]["tmp_name"][$key], $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/{$_FILES["selectedImages"]["name"][$key]}");

                        QueryExecutor::getInstance()->addProductPhoto($_GET["productId"], $_FILES["selectedImages"]["name"][$key]);
                    }
                }
            }

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/Product/");
            exit();
        }
        else{
            $_SESSION["error"] = "Продукт с такими данными уже существует.";

            header("Location: EditProduct.php?productId=" . $_GET["productId"]);
            exit();
        }
    }
    else {
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditProduct.php?productId=" . $_GET["productId"]);
        exit();
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "Применить"){
    $products = QueryExecutor::getInstance()->getProducts($_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["manufacturerId"], null, null, $_POST["inputSearch"]);

    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/TableProducts.php";
    exit();
}

if(!isset($_POST["action"])){
    $products = QueryExecutor::getInstance()->getProducts($_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["categorySubcategoryId"], $_POST["manufacturerId"], null, null, $_POST["inputSearch"]);

    include "Products.php";
    exit();
}
?>