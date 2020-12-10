<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Logic/Database/QueryExecutor.php";

session_start();

$classifications = array();
$categoriesSubcategory = array();

if(isset($_POST["action"]) && $_POST["action"] == "Добавить"){
    header("Location: AddCategorySubcategory.php");
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Изменить"){
    header("Location: EditCategorySubcategory.php?categorySubcategoryId=" . $_POST["selectedCategorySubcategory"]);
    exit();
}

if(isset($_POST["action"]) && $_POST["action"] == "Удалить"){
    QueryExecutor::getInstance()->removeCategorySubcategory($_POST["selectedCategorySubcategory"]);

    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $categoriesSubcategory = QueryExecutor::getInstance()->getCategoriesSubcategory($_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["inputSearch"]);

    include "CategoriesSubcategory.php";
}

if(isset($_POST["action"]) && $_POST["action"] == "Записать") {
    if (isset($_POST["subcategoryId"]) && $_POST["subcategoryId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsCategorySubcategory($_POST["subcategoryId"], $_POST["name"])) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->addCategorySubcategory($_POST["subcategoryId"], $_POST["name"], $fileName);

            header("Location: http://" . $_SERVER["SERVER_NAME"] . "/Views/Pages/Administrator/CategorySubcategory/");
            exit();
        }
        else{
            $_SESSION["error"] = "Категория подкатегории с такими данными уже существует.";

            header("Location: AddCategorySubcategory.php");
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: AddCategorySubcategory.php");
        exit();
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "Сохранить") {
    if (isset($_POST["subcategoryId"]) && $_POST["subcategoryId"] > 0 && iconv_strlen($_POST["name"], "UTF-8") > 0) {
        if (!QueryExecutor::getInstance()->containsCategorySubcategory($_POST["subcategoryId"], $_POST["name"]) || $_GET["photo"] != $_FILES["selectedImage"]["tmp_name"]) {
            $fileName = $_FILES["selectedImage"]["name"];
            $tmpFileName = $_FILES["selectedImage"]["tmp_name"];

            if(isset($fileName) && isset($tmpFileName)){
                move_uploaded_file($tmpFileName, $_SERVER["DOCUMENT_ROOT"] . "/Resources/Images/Upload/$fileName");
            }

            QueryExecutor::getInstance()->updateCategorySubcategory($_GET["categorySubcategoryId"], $_POST["subcategoryId"], $_POST["name"], iconv_strlen($fileName) > 0 ? $fileName : $_GET["photo"]);

            header("Location: http://" . $_SERVER["SERVER_NAME"] ."/Views/Pages/Administrator/CategorySubcategory/");
            exit();
        }
        else{
            $_SESSION["error"] = "Категория подкатегории с такими данными уже существует.";

            header("Location: EditCategorySubcategory.php?categorySubcategoryId=" . $_GET["categorySubcategoryId"]);
            exit();
        }
    }
    else{
        $_SESSION["error"] = "Введены неверные данные.";

        header("Location: EditCategorySubcategory.php?categorySubcategoryId=" . $_GET["categorySubcategoryId"]);
        exit();
    }
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

if(!isset($_POST["action"]) || $_POST["action"] == "Поиск"){
    $classifications = QueryExecutor::getInstance()->getClassifications("");
    $categoriesSubcategory = QueryExecutor::getInstance()->getCategoriesSubcategory($_POST["classificationId"], $_POST["categoryId"], $_POST["subcategoryId"], $_POST["inputSearch"]);

    include "CategoriesSubcategory.php";
}
?>