<?php
class QueryExecutor{
    protected static $instance;

    private $contextDb;

    private function __construct(){
        $this->contextDb = new PDO("mysql:dbname=electronics_store;host=localhost", "root", "root");
    }

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new QueryExecutor();
        }

        return self::$instance;
    }

    public function authorization($login, $password){
        return !is_null($this->executeQuery("SELECT * FROM v_user WHERE login='$login' AND password='$password' LIMIT 1")[0]);
    }

    public function containsUser($login){
        return !is_null($this->executeQuery("SELECT * FROM user WHERE login='$login' LIMIT 1")[0]);
    }

    public function registration($roleId, $login, $password){
        $dateTime = date("y-m-d H:i:s");
        $this->executeQuery("INSERT INTO user (role_id, avatar, login, password, date_of_registration) VALUES($roleId, NULL, '$login', '$password', '$dateTime')");
    }

    public function getUser($login){
        return $this->executeQuery("SELECT * FROM v_user WHERE login='$login' LIMIT 1")[0];
    }

    public function getRoles(){
        return $this->executeQuery("SELECT * FROM role");
    }

    public function getCountries($name){
        return $this->executeQuery("SELECT * FROM country WHERE name LIKE '%$name%'");
    }

    public function removeCountry($id){
        $this->executeQuery("DELETE FROM country WHERE id=$id");
    }

    public function containsCountry($name){
        return !is_null($this->executeQuery("SELECT * FROM country WHERE name='$name' LIMIT 1")[0]);
    }

    public function addCountry($name, $flag){
        $this->executeQuery("INSERT INTO country (name, flag) VALUES ('$name', '$flag')");
    }

    public function getCountry($id){
        return $this->executeQuery("SELECT * FROM country WHERE id=$id LIMIT 1")[0];
    }

    public function updateCountry($id, $name, $flag){
        $this->executeQuery("UPDATE country SET name='$name', flag='$flag' WHERE id=$id");
    }

    public function getRegions($countryId = null, $name){
        $condition = isset($countryId) && $countryId > 0 ? " AND country_id=$countryId" : "";

        $query = "SELECT * FROM v_region WHERE name LIKE '%$name%'";
        $query .= $condition;

        return $this->executeQuery($query);
    }

    public function containsRegion($countryId, $name){
        return !is_null($this->executeQuery("SELECT * FROM region WHERE country_id=$countryId AND name='$name' LIMIT 1")[0]);
    }

    public function addRegion($countryId, $name){
        $this->executeQuery("INSERT INTO region (country_id, name) VALUES ($countryId, '$name')");
    }

    public function removeRegion($id){
        $this->executeQuery("DELETE FROM region WHERE id=$id");
    }

    public function getRegion($id){
        return $this->executeQuery("SELECT * FROM region WHERE id=$id LIMIT 1")[0];
    }

    public function updateRegion($id, $countryId, $name){
        $this->executeQuery("UPDATE region SET country_id=$countryId, name='$name' WHERE id=$id");
    }

    public function getCities($countryId = null, $regionId = null, $name){
        $condition1 = isset($countryId) && $countryId > 0 ? " AND country_id=$countryId" : "";
        $condition2 = isset($regionId) && $regionId > 0 ? " AND region_id=$regionId" : "";

        $query = "SELECT * FROM v_city WHERE name LIKE '%$name%'";
        $query .= $condition1;
        $query .= $condition2;

        return $this->executeQuery($query);
    }

    public function containsCity($regionId, $name){
        return !is_null($this->executeQuery("SELECT * FROM city WHERE region_id=$regionId AND name='$name' LIMIT 1")[0]);
    }

    public function addCity($regionId, $name){
        $this->executeQuery("INSERT INTO city (region_id, name) VALUES ($regionId, '$name')");
    }

    public function removeCity($id){
        $this->executeQuery("DELETE FROM city WHERE id=$id");
    }

    public function getCity($id){
       return $this->executeQuery("SELECT * FROM v_city WHERE id=$id LIMIT 1")[0];
    }

    public function updateCity($id, $regionId, $name){
        $this->executeQuery("UPDATE city SET region_id=$regionId, name='$name' WHERE id=$id");
    }

    public function getStreets($countryId = null, $regionId = null, $cityId = null, $name){
        $condition1 = isset($countryId) && $countryId > 0 ? " AND country_id=$countryId" : "";
        $condition2 = isset($regionId) && $regionId > 0 ? " AND region_id=$regionId" : "";
        $condition3 = isset($cityId) && $cityId > 0 ? " AND city_id=$cityId" : "";

        $query = "SELECT * FROM v_street WHERE name LIKE '%$name%'";
        $query .= $condition1;
        $query .= $condition2;
        $query .= $condition3;

        return $this->executeQuery($query);
    }

    public function containsStreet($cityId, $name){
        return !is_null($this->executeQuery("SELECT * FROM street WHERE city_id=$cityId AND name='$name' LIMIT 1")[0]);
    }

    public function addStreet($cityId, $name){
        $this->executeQuery("INSERT INTO street (city_id, name) VALUES ($cityId, '$name')");
    }

    public function getStreet($id){
        return $this->executeQuery("SELECT * FROM v_street WHERE id=$id LIMIT 1")[0];
    }

    public function updateStreet($id, $cityId, $name){
        $this->executeQuery("UPDATE street SET city_id=$cityId, name='$name' WHERE id=$id");
    }

    public function removeStreet($id){
        $this->executeQuery("DELETE FROM street WHERE id=$id");
    }

    public function getHouses($countryId = null, $regionId = null, $cityId = null, $streetId = null, $name){
        $condition1 = isset($countryId) && $countryId > 0 ? " AND country_id=$countryId" : "";
        $condition2 = isset($regionId) && $regionId > 0 ? " AND region_id=$regionId" : "";
        $condition3 = isset($cityId) && $cityId > 0 ? " AND city_id=$cityId" : "";
        $condition4 = isset($streetId) && $streetId > 0 ? " AND street_id=$streetId" : "";

        $query = "SELECT * FROM v_house WHERE name LIKE '%$name%'";
        $query .= $condition1;
        $query .= $condition2;
        $query .= $condition3;
        $query .= $condition4;

        return $this->executeQuery($query);
    }

    public function containsHouse($streetId, $name){
        return !is_null($this->executeQuery("SELECT * FROM house WHERE street_id=$streetId AND name='$name' LIMIT 1")[0]);
    }

    public function addHouse($streetId, $name){
        $this->executeQuery("INSERT INTO house (street_id, name) VALUES ($streetId, '$name')");
    }

    public function getHouse($id){
        return $this->executeQuery("SELECT * FROM v_house WHERE id=$id LIMIT 1")[0];
    }

    public function updateHouse($id, $streetId, $name){
        $this->executeQuery("UPDATE house SET street_id=$streetId, name=$name WHERE id=$id");
    }

    public function removeHouse($id){
        $this->executeQuery("DELETE FROM house WHERE id=$id");
    }

    public function getClassifications($name){
        return $this->executeQuery("SELECT * FROM classification WHERE name LIKE '%$name%'");
    }

    public function containsClassification($name){
        return !is_null($this->executeQuery("SELECT * FROM classification WHERE name='$name' LIMIT 1")[0]);
    }

    public function addClassification($name, $photo){
        $this->executeQuery("INSERT INTO classification (name, photo) VALUES ('$name', '$photo')");
    }

    public function getClassification($id){
        return $this->executeQuery("SELECT * FROM classification WHERE id=$id LIMIT 1")[0];
    }

    public function updateClassification($id, $name, $photo){
        $this->executeQuery("UPDATE classification SET name='$name', photo='$photo' WHERE id=$id");
    }

    public function removeClassification($id){
        $this->executeQuery("DELETE FROM classification WHERE id=$id");
    }

    public function getCategories($classificationId = null, $name){
        $condition1 = isset($classificationId) && $classificationId > 0 ? " AND classification_id=$classificationId" : "";

        $query = "SELECT * FROM v_category WHERE name LIKE '%$name%'";
        $query .= $condition1;

        return $this->executeQuery($query);
    }

    public function containsCategory($classificationId, $name){
        return !is_null($this->executeQuery("SELECT * FROM category WHERE classification_id=$classificationId AND name='$name' LIMIT 1")[0]);
    }

    public function addCategory($classificationId, $name, $photo){
        $this->executeQuery("INSERT INTO category (classification_id, name, photo) VALUES ($classificationId, '$name', '$photo')");
    }

    public function getCategory($id){
        return $this->executeQuery("SELECT * FROM v_category WHERE id=$id LIMIT 1")[0];
    }

    public function updateCategory($id, $classificationId, $name, $photo){
        $this->executeQuery("UPDATE category SET classification_id=$classificationId, name='$name', photo='$photo' WHERE id=$id");
    }

    public function removeCategory($id){
        $this->executeQuery("DELETE FROM category WHERE id=$id");
    }

    public function getSubcategories($classificationId = null, $categoryId = null, $name){
        $condition1 = isset($classificationId) && $classificationId > 0 ? " AND classification_id=$classificationId" : "";
        $condition2 = isset($categoryId) && $categoryId > 0 ? " AND category_id=$categoryId" : "";

        $query = "SELECT * FROM v_subcategory WHERE name LIKE '%$name%'";
        $query .= $condition1;
        $query .= $condition2;

        return $this->executeQuery($query);
    }

    public function containsSubcategory($categoryId, $name){
        return !is_null($this->executeQuery("SELECT * FROM subcategory WHERE category_id=$categoryId AND name='$name' LIMIT 1")[0]);
    }

    public function addSubcategory($categoryId, $name, $photo){
        $this->executeQuery("INSERT INTO subcategory (category_id, name, photo) VALUES ($categoryId, '$name', '$photo')");
    }

    public function getSubcategory($id){
        return $this->executeQuery("SELECT * FROM v_subcategory WHERE id=$id LIMIT 1")[0];
    }

    public function updateSubcategory($id, $categoryId, $name, $photo){
        $this->executeQuery("UPDATE subcategory SET category_id=$categoryId, name='$name', photo='$photo' WHERE id=$id");
    }

    public function removeSubcategory($id){
        $this->executeQuery("DELETE FROM subcategory WHERE id=$id");
    }

    public function getCategoriesSubcategory($classificationId = null, $categoryId = null, $subcategoryId = null, $name){
        $condition1 = isset($classificationId) && $classificationId > 0 ? " AND classification_id=$classificationId" : "";
        $condition2 = isset($categoryId) && $categoryId > 0 ? " AND category_id=$categoryId" : "";
        $condition3 = isset($subcategoryId) && $subcategoryId > 0 ? " AND subcategory_id=$subcategoryId" : "";

        $query = "SELECT * FROM v_category_subcategory WHERE name LIKE '%$name%'";

        $query .= $condition1;
        $query .= $condition2;
        $query .= $condition3;

        return $this->executeQuery($query);
    }

    public function containsCategorySubcategory($subcategoryId, $name){
        return !is_null($this->executeQuery("SELECT * FROM category_subcategory WHERE subcategory_id=$subcategoryId AND name='$name' LIMIT 1")[0]);
    }

    public function addCategorySubcategory($subcategoryId, $name, $photo){
        $this->executeQuery("INSERT INTO category_subcategory (subcategory_id, name, photo) VALUES ($subcategoryId, '$name', '$photo')");
    }

    public function getCategorySubcategory($id){
        return $this->executeQuery("SELECT * FROM v_category_subcategory WHERE id=$id LIMIT 1")[0];
    }

    public function updateCategorySubcategory($id, $subcategoryId, $name, $photo){
        $this->executeQuery("UPDATE category_subcategory SET subcategory_id=$subcategoryId, name='$name', photo='$photo' WHERE id=$id");
    }

    public function removeCategorySubcategory($id){
        $this->executeQuery("DELETE FROM category_subcategory WHERE id=$id");
    }

    public function getManufacturers($name){
        return $this->executeQuery("SELECT * FROM manufacturer WHERE name LIKE '%$name%'");
    }

    public function containsManufacturer($name){
        return !is_null($this->executeQuery("SELECT * FROM manufacturer WHERE name='$name' LIMIT 1")[0]);
    }

    public function addManufacturer($name, $photo){
        $this->executeQuery("INSERT INTO manufacturer (name, photo) VALUES ('$name', '$photo')");
    }

    public function getManufacturer($id){
        return $this->executeQuery("SELECT * FROM manufacturer WHERE id=$id LIMIT 1")[0];
    }

    public function updateManufacturer($id, $name, $photo){
        $this->executeQuery("UPDATE manufacturer SET name='$name', photo='$photo' WHERE id=$id");
    }

    public function removeManufacturer($id){
        $this->executeQuery("DELETE FROM manufacturer WHERE id=$id");
    }

    public function getCharacteristics($name){
        return $this->executeQuery("SELECT * FROM characteristic WHERE name LIKE '%$name%'");
    }

    public function containsCharacteristic($name){
        return !is_null($this->executeQuery("SELECT * FROM characteristic WHERE name='$name' LIMIT 1")[0]);
    }

    public function addCharacteristic($name){
        $this->executeQuery("INSERT INTO characteristic (name) VALUES ('$name')");

        return $this->contextDb->lastInsertId();
    }

    public function getCharacteristic($id){
        return $this->executeQuery("SELECT * FROM characteristic WHERE id=$id LIMIT 1")[0];
    }

    public function updateCharacteristic($id, $name){
        $this->executeQuery("UPDATE characteristic SET name='$name' WHERE id=$id");
    }

    public function removeCharacteristic($id){
        $this->executeQuery("DELETE FROM characteristic WHERE id=$id");
    }

    public function getQuantities($name){
        return $this->executeQuery("SELECT * FROM quantity WHERE name LIKE '%$name%'");
    }

    public function containsQuantity($name){
        return !is_null($this->executeQuery("SELECT * FROM quantity WHERE name='$name' LIMIT 1")[0]);
    }

    public function addQuantity($name){
        $this->executeQuery("INSERT INTO quantity (name) VALUES ('$name')");
    }

    public function getQuantity($id){
        return $this->executeQuery("SELECT * FROM quantity WHERE id=$id LIMIT 1")[0];
    }

    public function updateQuantity($id, $name){
        $this->executeQuery("UPDATE quantity SET name='$name' WHERE id=$id");
    }

    public function removeQuantity($id){
        $this->executeQuery("DELETE FROM quantity WHERE id=$id");
    }

    public function getCharacteristicsCategorySubcategory($sectionId = null, $classificationId = null, $categoryId = null, $subcategoryId = null, $categorySubcategoryId = null, $characteristicId = null, $useWhenFiltering = null, $useWhenDisplayingAsBasicInformation = null, $name){
        $condition1 = isset($sectionId) && $sectionId > 0 ? " AND section_id=$sectionId" : "";
        $condition2 = isset($classificationId) && $classificationId > 0 ? " AND classification_id=$classificationId" : "";
        $condition3 = isset($categoryId) && $categoryId > 0 ? " AND category_id=$categoryId" : "";
        $condition4 = isset($subcategoryId) && $subcategoryId > 0 ? " AND subcategory_id=$subcategoryId" : "";
        $condition5 = isset($categorySubcategoryId) && $categorySubcategoryId > 0 ? " AND category_subcategory_id=$categorySubcategoryId" : "";
        $condition6 = isset($characteristicId) && $characteristicId > 0 ? " AND characteristic_id=$characteristicId" : "";
        $condition7 = isset($useWhenFiltering) && $useWhenFiltering >= 0 && iconv_strlen($useWhenFiltering, "UTF-8") > 0 ? " AND use_when_filtering=$useWhenFiltering" : "";
        $condition8 = isset($useWhenDisplayingAsBasicInformation) && $useWhenDisplayingAsBasicInformation >= 0 && iconv_strlen($useWhenDisplayingAsBasicInformation, "UTF-8") > 0 ? " AND use_when_displaying_as_basic_information=$useWhenDisplayingAsBasicInformation" : "";

        $query = "SELECT * FROM v_characteristic_category_subcategory WHERE characteristic_name LIKE '%$name%'";
        $query .= $condition1;
        $query .= $condition2;
        $query .= $condition3;
        $query .= $condition4;
        $query .= $condition5;
        $query .= $condition6;
        $query .= $condition7;
        $query .= $condition8;

        return $this->executeQuery($query);
    }

    public function containsCharacteristicCategorySubcategory($characteristicId, $categorySubcategoryId){
        return !is_null($this->executeQuery("SELECT * FROM characteristic_category_subcategory WHERE characteristic_id=$characteristicId AND category_subcategory_id = $categorySubcategoryId LIMIT 1")[0]);
    }

    public function addCharacteristicCategorySubcategory($characteristicId, $categorySubcategoryId, $sectionCategorySubcategoryId, $useWhenFiltering, $useWhenDisplayingAsBasicInformation){
        $useWhenFiltering = isset($useWhenFiltering) ? 1 : 0;
        $useWhenDisplayingAsBasicInformation = isset($useWhenDisplayingAsBasicInformation) ? 1 : 0;

        $this->executeQuery("INSERT INTO characteristic_category_subcategory (characteristic_id, category_subcategory_id, section_category_subcategory_id, use_when_filtering, use_when_displaying_as_basic_information) VALUES ($characteristicId, $categorySubcategoryId, $sectionCategorySubcategoryId, $useWhenFiltering, $useWhenDisplayingAsBasicInformation)");
    }

    public function getCharacteristicCategorySubcategory($id){
        return $this->executeQuery("SELECT * FROM v_characteristic_category_subcategory WHERE id=$id LIMIT 1")[0];
    }

    public function updateCharacteristicCategorySubcategory($id, $characteristicId, $categorySubcategoryId, $sectionCategorySubcategoryId, $useWhenFiltering, $useWhenDisplayingAsBasicInformation){
        $useWhenFiltering = isset($useWhenFiltering) ? 1 : 0;
        $useWhenDisplayingAsBasicInformation = isset($useWhenDisplayingAsBasicInformation) ? 1 : 0;

        $this->executeQuery("UPDATE characteristic_category_subcategory SET characteristic_id=$characteristicId, category_subcategory_id=$categorySubcategoryId, section_category_subcategory_id=$sectionCategorySubcategoryId, use_when_filtering=$useWhenFiltering, use_when_displaying_as_basic_information=$useWhenDisplayingAsBasicInformation WHERE id=$id");
    }

    public function removeCharacteristicCategorySubcategory($id){
        $this->executeQuery("DELETE FROM characteristic_category_subcategory WHERE id=$id");
    }

    public function getUnits($name){
        return $this->executeQuery("SELECT * FROM unit WHERE name LIKE '%$name%'");
    }

    public function containsUnit($name, $designation = null){
        $condition1 = isset($designation) ? " AND designation='$designation'" : "";
        $condition2 = " LIMIT 1";

        $query = "SELECT * FROM unit WHERE name='$name'";
        $query .= $condition1;
        $query .= $condition2;

        return !is_null($this->executeQuery($query)[0]);
    }

    public function addUnit($name, $designation){
        $this->executeQuery("INSERT INTO unit (name, designation) VALUES ('$name', '$designation')");
    }

    public function getUnit($id){
        return $this->executeQuery("SELECT * FROM unit WHERE id=$id LIMIT 1")[0];
    }

    public function updateUnit($id, $name, $designation){
        $this->executeQuery("UPDATE unit SET name='$name', designation='$designation' WHERE id=$id");
    }

    public function removeUnit($id){
        $this->executeQuery("DELETE FROM unit WHERE id=$id");
    }

    public function getQuantityUnits($quantityId = null, $unitId = null, $name){
        $condition1 = isset($quantityId) && $quantityId > 0 ? " AND quantity_id=$quantityId" : "";
        $condition2 = isset($unitId) && $unitId > 0 ? " AND unit_id=$unitId" : "";

        $query = "SELECT * FROM v_quantity_unit WHERE quantity_name LIKE '%$name%'";
        $query .= $condition1;
        $query .= $condition2;

        return $this->executeQuery($query);
    }

    public function containsQuantityUnit($quantityId, $unitId){
        return !is_null($this->executeQuery("SELECT * FROM quantity_unit WHERE quantity_id=$quantityId AND unit_id=$unitId LIMIT 1")[0]);
    }

    public function addQuantityUnit($quantityId, $unitId){
        $this->executeQuery("INSERT INTO quantity_unit (quantity_id, unit_id) VALUES ($quantityId, $unitId)");
    }

    public function getQuantityUnit($id){
        return $this->executeQuery("SELECT * FROM v_quantity_unit WHERE id=$id LIMIT 1")[0];
    }

    public function updateQuantityUnit($id, $quantityId, $unitId){
        $this->executeQuery("UPDATE quantity_unit SET quantity_id=$quantityId, unit_id=$unitId WHERE id=$id");
    }

    public function removeQuantityUnit($id){
        $this->executeQuery("DELETE FROM quantity_unit WHERE id=$id");
    }

    public function getCharacteristicQuantityUnitValues($characteristicId = null, $quantityId = null, $unitId = null, $value){
        $condition1 = isset($characteristicId) && $characteristicId > 0 ? " AND characteristic_id=$characteristicId" : "";
        $condition2 = isset($quantityId) && $quantityId > 0 ? " AND quantity_id=$quantityId" : "";
        $condition3 = isset($unitId) && $unitId > 0 ? " AND unit_id=$unitId" : "";

        $query = "SELECT * FROM v_characteristic_quantity_unit_value WHERE value LIKE '%$value%'";
        $query .= $condition1;
        $query .= $condition2;
        $query .= $condition3;

        return $this->executeQuery($query);
    }

    public function getUsedCharacteristicQuantityUnitValues($characteristicId, $categorySubcategoryId){
        $query = "SELECT DISTINCT
                 v_characteristic_quantity_unit_value.id,
                 v_characteristic_quantity_unit_value.characteristic_id,
                 v_characteristic_quantity_unit_value.characteristic_name,
                 v_characteristic_quantity_unit_value.quantity_unit_id,
                 v_characteristic_quantity_unit_value.quantity_id,
                 v_characteristic_quantity_unit_value.quantity_name,
                 v_characteristic_quantity_unit_value.unit_id,
                 v_characteristic_quantity_unit_value.unit_name,
                 v_characteristic_quantity_unit_value.unit_designation,
                 v_characteristic_quantity_unit_value.value
                 FROM v_characteristic_quantity_unit_value INNER JOIN 
                 product_characteristic_quantity_unit_value ON product_characteristic_quantity_unit_value.characteristic_quantity_unit_value_id = v_characteristic_quantity_unit_value.id INNER JOIN
                 product ON product.id = product_characteristic_quantity_unit_value.product_id AND product.category_subcategory_id = $categorySubcategoryId
                 WHERE characteristic_id = $characteristicId";

        return $this->executeQuery($query);
    }

    public function containsCharacteristicQuantityUnitValue($characteristicId, $quantityUnitId, $value){
        return !is_null($this->executeQuery("SELECT * FROM characteristic_quantity_unit_value WHERE characteristic_id=$characteristicId AND quantity_unit_id=$quantityUnitId AND value='$value' LIMIT 1")[0]);
    }

    public function addCharacteristicQuantityUnitValue($characteristicId, $quantityUnitId, $value){
        $this->executeQuery("INSERT INTO characteristic_quantity_unit_value (characteristic_id, quantity_unit_id, value) VALUES ($characteristicId, $quantityUnitId, '$value')");

        return $this->contextDb->lastInsertId();
    }

    public function getCharacteristicQuantityUnitValue($id){
        return $this->executeQuery("SELECT * FROM v_characteristic_quantity_unit_value WHERE id=$id LIMIT 1")[0];
    }

    public function updateCharacteristicQuantityUnitValue($id, $characteristicId, $quantityUnitId, $value){
        $this->executeQuery("UPDATE characteristic_quantity_unit_value SET characteristic_id=$characteristicId, quantity_unit_id=$quantityUnitId, value='$value' WHERE id=$id");
    }

    public function removeCharacteristicQuantityUnitValue($id){
        $this->executeQuery("DELETE FROM characteristic_quantity_unit_value WHERE id=$id");
    }

    public function containsProduct($manufacturerId, $model){
        return !is_null($this->executeQuery("SELECT * FROM product WHERE manufacturer_id=$manufacturerId AND model='$model' LIMIT 1")[0]);
    }

    public function addProduct($categorySubcategoryId, $manufacturerId, $photo, $model, $description, $price){
        $this->executeQuery("INSERT INTO product (category_subcategory_id, manufacturer_id, photo, model, description, price) VALUES ($categorySubcategoryId, $manufacturerId, '$photo', '$model', '$description', $price)");

        return $this->contextDb->lastInsertId();
    }

    public function addProductCharacteristicQuantityUnitValue($productId, $characteristicQuantityUnitValueId){
        $this->executeQuery("INSERT INTO product_characteristic_quantity_unit_value (product_id, characteristic_quantity_unit_value_id) VALUES ($productId, $characteristicQuantityUnitValueId)");
    }

    public function getMinPriceProduct($categorySubcategoryId){
        return $this->executeQuery("SELECT MIN(price) AS `min_price` FROM product WHERE product.category_subcategory_id=$categorySubcategoryId")[0];
    }

    public function getMaxPriceProduct($categorySubcategoryId){
        return $this->executeQuery("SELECT MAX(price) AS `max_price` FROM product WHERE product.category_subcategory_id=$categorySubcategoryId")[0];
    }

    public function getMinEvaluationProduct($categorySubcategoryId){
        return $this->executeQuery("SELECT MIN(v_product.evaluation) AS `min_evaluation` FROM v_product WHERE v_product.category_subcategory_id=$categorySubcategoryId");
    }

    public function getMaxEvaluationProduct($categorySubcategoryId){
        return $this->executeQuery("SELECT MAX(v_product.evaluation) AS `max_evaluation` FROM v_product WHERE v_product.category_subcategory_id=$categorySubcategoryId");
    }

    public function getProducts($classificationId = null, $categoryId = null, $subcategoryId = null, $categorySubcategoryId = null, $manufacturerId = null,  $minPrice = null, $maxPrice = null, $model, $name = null, $characteristicQuantityUnitValues = null, $manufacturers = null, $minEvaluation = null, $maxEvaluation = null){
        $condition1 = isset($classificationId) && $classificationId > 0 ? " AND classification_id=$classificationId" : "";
        $condition2 = isset($categoryId) && $categoryId > 0 ? " AND category_id=$categoryId" : "";
        $condition3 = isset($subcategoryId) && $subcategoryId > 0 ? " AND subcategory_id=$subcategoryId" : "";
        $condition4 = isset($categorySubcategoryId) && $categorySubcategoryId > 0 ? " AND category_subcategory_id=$categorySubcategoryId" : "";
        $condition5 = isset($characteristicId) && $characteristicId > 0 ? " AND characteristic_id=$characteristicId" : "";
        $condition6 = isset($manufacturerId) && $manufacturerId > 0 ? " AND manufacturer_id=$manufacturerId" : "";
        $condition7 = isset($minPrice) && $minPrice >= 0 ? " AND price >= $minPrice" : "";
        $condition8 = isset($maxPrice) && $maxPrice <= 0 ? " AND price <= $maxPrice" : "";
        $condition9 = isset($minEvaluation) && $minEvaluation >= 1 ? " AND (evaluation >= $minEvaluation OR evaluation IS NULL)" : "";
        $condition10 = isset($maxEvaluation) && $maxEvaluation <= 5 ? " AND (evaluation <= $maxEvaluation  OR evaluation IS NULL)" : "";
        $condition11 = isset($name) && iconv_strlen($name, "UTF-8") > 0 ? " AND name LIKE '%$name%'" : "";

        $query = "SELECT DISTINCT *
                  FROM v_product
                  WHERE v_product.model LIKE '%$model%'";

        $query .= $condition1;
        $query .= $condition2;
        $query .= $condition3;
        $query .= $condition4;
        $query .= $condition5;
        $query .= $condition6;
        $query .= $condition7;
        $query .= $condition8;
        $query .= $condition9;
        $query .= $condition10;
        $query .= $condition11;

        if(isset($manufacturers) && count($manufacturers) > 0){
            $conditions = array();

            foreach ($manufacturers as $key => $value){
                array_push($conditions, $value);
            }

            $condition = implode(", ", $conditions);
            $query .= " AND manufacturer_id IN ($condition)";
        }

        if(isset($characteristicQuantityUnitValues) && count($characteristicQuantityUnitValues) > 0){
            $conditions = array();

            foreach ($characteristicQuantityUnitValues as $key => $value){
                 array_push($conditions, "(SELECT COUNT(*) FROM product_characteristic_quantity_unit_value AS p WHERE p.product_id = v_product.id AND p.characteristic_quantity_unit_value_id IN (" . implode(", ", $value) . ")) > 0");
            }

            $condition = implode(" AND ", $conditions);
            $query .= " AND $condition";
        }

        //echo $query;

        return $this->executeQuery($query);
    }

    public function getProduct($id){
        return $this->executeQuery("SELECT * FROM v_product WHERE id=$id LIMIT 1")[0];
    }

    public function getProductCharacteristicsQuantityUnitValues($id){
        return $this->executeQuery("SELECT * FROM product_characteristic_quantity_unit_value WHERE product_id=$id");
    }

    public function getProductCharacteristicsQuantityUnitValuesDetailedInformation($id, $useWhenDisplayingAsBasicInformation = null){
        $condition = isset($useWhenDisplayingAsBasicInformation) && $useWhenDisplayingAsBasicInformation >= 0 && iconv_strlen($useWhenDisplayingAsBasicInformation, "UTF-8") > 0 ? " AND use_when_displaying_as_basic_information=$useWhenDisplayingAsBasicInformation" : "";

        $query = "SELECT * FROM v_product_characteristic_quantity_unit_value WHERE product_id=$id";
        $query .= $condition;

        return $this->executeQuery($query);
    }

    public function removeAllProductCharacteristicsQuantityUnitValues($id){
        $this->executeQuery("DELETE FROM product_characteristic_quantity_unit_value WHERE product_id=$id");
    }

    public function updateProduct($id, $categorySubcategoryId, $manufacturerId, $photo, $model, $description, $price){
        $this->executeQuery("UPDATE product SET category_subcategory_id=$categorySubcategoryId, manufacturer_id=$manufacturerId, photo='$photo', model='$model', description='$description', price=$price WHERE id=$id");
    }

    public function removeProduct($id){
        $this->executeQuery("DELETE FROM product WHERE id=$id");
    }

    public function getManufacturersProducts($categorySubcategoryId){
        return $this->executeQuery("SELECT product.manufacturer_id, manufacturer.name AS `manufacturer_name` FROM product INNER JOIN manufacturer ON manufacturer.id = product.manufacturer_id WHERE product.category_subcategory_id = $categorySubcategoryId GROUP BY product.manufacturer_id");
    }

    public function addPurchase($userId){
        $date = date("Y-m-d H:i:s");
        $this->executeQuery("INSERT INTO purchase (user_id, date_purchase) VALUES ($userId, '$date')");

        return $this->contextDb->lastInsertId();
    }

    public function addPurchaseContent($purchaseId, $basket){
        foreach ($basket as $key => $value){
            $this->executeQuery("INSERT INTO purchase_content (purchase_id, product_id	, quantity) VALUES ($purchaseId, {$value["productId"]}, {$value["number"]})");
        }
    }

    public function getCharacteristicQuantityUnitValueId($characteristicId, $quantityUnitId, $value){
        return $this->executeQuery("SELECT * FROM characteristic_quantity_unit_value WHERE characteristic_id=$characteristicId AND quantity_unit_id=$quantityUnitId AND value='$value'  LIMIT 1")[0]["id"];
    }

    public function getSections($name){
        return $this->executeQuery("SELECT * FROM section WHERE name LIKE '%$name%'");
    }

    public function containsSection($name){
        return !is_null($this->executeQuery("SELECT * FROM section WHERE name='$name' LIMIT 1")[0]);
    }

    public function addSection($name){
        $this->executeQuery("INSERT INTO section (name) VALUES ('$name')");
    }

    public function getSection($id){
        return $this->executeQuery("SELECT * FROM section WHERE id=$id LIMIT 1 ")[0];
    }

    public function updateSection($id, $name){
        $this->executeQuery("UPDATE section SET name='$name' WHERE id=$id");
    }

    public function removeSection($id){
        $this->executeQuery("DELETE FROM section WHERE id=$id");
    }

    public function getSectionsCategorySubcategory($sectionId, $classificationId, $categoryId, $subcategoryId, $categorySubcategoryId, $name){
        $condition1 = isset($sectionId) && $sectionId > 0 ? " AND section_id=$sectionId" : "";
        $condition2 = isset($classificationId) && $classificationId > 0 ? " AND classification_id=$classificationId" : "";
        $condition3 = isset($categoryId) && $categoryId > 0 ? " AND category_id=$categoryId" : "";
        $condition4 = isset($subcategoryId) && $subcategoryId > 0 ? " AND subcategory_id=$subcategoryId" : "";
        $condition5 = isset($categorySubcategoryId) && $categorySubcategoryId > 0 ? " AND category_subcategory_id=$categorySubcategoryId" : "";

        $query = "SELECT * FROM v_section_category_subcategory WHERE section_name LIKE '%$name%'";
        $query .= $condition1;
        $query .= $condition2;
        $query .= $condition3;
        $query .= $condition4;
        $query .= $condition5;

        return $this->executeQuery($query);
    }

    public function containsSectionCategorySubcategory($sectionId, $categorySubcategoryId){
        return !is_null($this->executeQuery("SELECT * FROM section_category_subcategory WHERE section_id=$sectionId AND category_subcategory_id=$categorySubcategoryId LIMIT 1")[0]);
    }

    public function addSectionCategorySubcategory($sectionId, $categorySubcategoryId){
        $this->executeQuery("INSERT INTO section_category_subcategory (section_id, category_subcategory_id) VALUES ($sectionId, $categorySubcategoryId)");
    }

    public function getSectionCategorySubcategory($id){
        return $this->executeQuery("SELECT * FROM v_section_category_subcategory WHERE id=$id LIMIT 1")[0];
    }

    public function updateSectionCategorySubcategory($id, $sectionId, $categorySubcategoryId){
        $this->executeQuery("UPDATE section_category_subcategory SET section_id=$sectionId, category_subcategory_id=$categorySubcategoryId WHERE id=$id");
    }

    public function removeSectionCategorySubcategory($id){
        $this->executeQuery("DELETE FROM section_category_subcategory WHERE id=$id");
    }

    public function getSectionsCategorySubcategoryProduct($id){
        $query = "SELECT DISTINCT v_product_characteristic_quantity_unit_value.section_category_subcategory_id, 
                  v_product_characteristic_quantity_unit_value.section_id, 
                  v_product_characteristic_quantity_unit_value.section_name
                  FROM v_product_characteristic_quantity_unit_value
                  WHERE v_product_characteristic_quantity_unit_value.product_id=$id";

        return $this->executeQuery($query);
    }

    public function getCharacteristicQuantityUnits($characteristicId, $quantityId, $unitId, $name){
        $condition1 = isset($characteristicId) && $characteristicId > 0 ? " AND characteristic_id=$characteristicId" : "";
        $condition2 = isset($quantityId) && $quantityId > 0 ? " AND quantity_id=$quantityId" : "";
        $condition3 = isset($unitId) && $unitId > 0 ? " AND unit_id=$unitId" : "";

        $query = "SELECT * FROM v_characteristic_quantity_unit WHERE characteristic_name LIKE '%$name%'";
        $query .= $condition1;
        $query .= $condition2;
        $query .= $condition3;

        return $this->executeQuery($query);
    }

    public function containsCharacteristicQuantityUnit($characteristicId, $quantityUnitId){
        return !is_null($this->executeQuery("SELECT * FROM characteristic_quantity_unit WHERE characteristic_id=$characteristicId AND quantity_unit_id=$quantityUnitId LIMIT 1")[0]);
    }

    public function addCharacteristicQuantityUnit($characteristicId, $quantityUnitId){
        $this->executeQuery("INSERT INTO characteristic_quantity_unit (characteristic_id, quantity_unit_id) VALUES ($characteristicId, $quantityUnitId)");
    }

    public function getCharacteristicQuantityUnit($id){
        return $this->executeQuery("SELECT * FROM v_characteristic_quantity_unit WHERE id=$id LIMIT 1")[0];
    }

    public function updateCharacteristicQuantityUnit($id, $characteristicId, $quantityUnitId){
        $this->executeQuery("UPDATE characteristic_quantity_unit SET characteristic_id=$characteristicId, quantity_unit_id=$quantityUnitId WHERE id=$id");
    }

    public function removeCharacteristicQuantityUnit($id){
        $this->executeQuery("DELETE FROM characteristic_quantity_unit WHERE id=$id");
    }

    public function removeAllCharacteristicQuantityUnits($characteristicId){
        $this->executeQuery("DELETE FROM characteristic_quantity_unit WHERE characteristic_id=$characteristicId");
    }

    public function getViewedProductsUser($userId){
        return $this->executeQuery("SELECT * FROM v_product_view WHERE user_id=$userId ORDER BY viewing_time DESC");
    }

    public function getViewedProductsStrangerUser($viewedProducts){
        if(iconv_strlen($viewedProducts, "UTF-8") > 0){
            return $this->executeQuery("SELECT * FROM v_product WHERE id IN ($viewedProducts)");
        }

        /*if(count($viewedProducts) > 0){
            $condition = "";
            $conditions = array();

            foreach ($viewedProducts as $key){
                array_push($conditions, $key["productId"]);
            }

            $condition = implode(", ", $conditions);

            return $this->executeQuery("SELECT * FROM v_product WHERE id IN ($condition)");
        }*/

        return $this->executeQuery("SELECT * FROM v_product LIMIT 0");
    }

    public function addProductView($productId, $userId){
        $dateTime = date("y-m-d H:i:s");
        $this->executeQuery("INSERT INTO product_view (product_id, user_id, viewing_time) VALUES ($productId, $userId, '$dateTime')");
    }

    public function containsProductView($productId, $userId){
        return !is_null($this->executeQuery("SELECT * FROM product_view WHERE product_id=$productId AND user_id=$userId LIMIT 1")[0]);
    }

    public function getFavoriteProductsUser($userId){
        return $this->executeQuery("SELECT * FROM v_product_favorite WHERE user_id=$userId");
    }

    public function getFavoriteProductsStrangerUser($favoriteProducts){
        if(iconv_strlen($favoriteProducts, "UTF-8") > 0){
            return $this->executeQuery("SELECT * FROM v_product_favorite WHERE product_id IN ($favoriteProducts)");
        }

        return $this->executeQuery("SELECT * FROM v_product_favorite LIMIT 0");
    }

    public function containsFavoriteProduct($productId, $userId){
        return !is_null($this->executeQuery("SELECT * FROM product_favorite WHERE product_id=$productId AND user_id=$userId LIMIT 1")[0]);
    }

    public function addFavoriteProduct($productId, $userId){
        $dateTime = date("y-m-d H:i:s");
        $this->executeQuery("INSERT INTO product_favorite (product_id, user_id, date_of_adding) VALUES ($productId, $userId, '$dateTime')");
    }

    public function removeFavoriteProduct($productId, $userId){
        $this->executeQuery("DELETE FROM product_favorite WHERE product_id=$productId AND user_id=$userId");
    }

    public function getCountOfLikesProduct($productId){
        return $this->executeQuery("SELECT COUNT(*) AS `count_of_likes` FROM product_favorite WHERE product_id=$productId")[0]["count_of_likes"];
    }

    public function containsPurchasedByUserProduct($productId, $userId){
        return !is_null($this->executeQuery("SELECT * FROM purchase INNER JOIN purchase_content ON purchase_content.purchase_id = purchase.id WHERE purchase_content.product_id=$productId"));
    }

    public function containsReview($productId, $userId){
        return !is_null($this->executeQuery("SELECT * FROM review WHERE product_id=$productId AND user_id=$userId LIMIT 1")[0]);
    }

    public function getProductPhotos($productId){
        return $this->executeQuery("SELECT * FROM product_photo WHERE product_id=$productId");
    }

    public function addProductPhoto($productId, $photo){
        $this->executeQuery("INSERT INTO product_photo (product_id, photo) VALUES ($productId, '$photo')");
    }

    public function removeAllProductPhoto($productId){
        $this->executeQuery("DELETE FROM product_photo WHERE product_id=$productId");
    }

    public function getEvaluationCriterions($name){
        return $this->executeQuery("SELECT * FROM evaluation_criterion WHERE name LIKE '%$name%'");
    }

    public function containsEvaluationCriterion($name){
        return !is_null($this->executeQuery("SELECT * FROM evaluation_criterion WHERE name='$name' LIMIT 1")[0]);
    }

    public function addEvaluationCriterion($name){
        $this->executeQuery("INSERT INTO evaluation_criterion (name) VALUES ('$name')");
    }

    public function getEvaluationCriterion($id){
        return $this->executeQuery("SELECT * FROM evaluation_criterion WHERE id=$id LIMIT 1")[0];
    }

    public function updateEvaluationCriterion($id, $name){
        $this->executeQuery("UPDATE evaluation_criterion SET name='$name' WHERE id=$id");
    }

    public function removeEvaluationCriterion($id){
        $this->executeQuery("DELETE FROM evaluation_criterion WHERE id=$id");
    }

    public function getEvaluationCriterionsCategorySubcategory($evaluationCriterionId = null, $classificationId = null, $categoryId = null, $subcategoryId = null, $categorySubcategoryId = null, $name){
        $condition1 = isset($evaluationCriterionId) && $evaluationCriterionId > 0 ? " AND evaluation_criterion_id=$evaluationCriterionId" : "";
        $condition2 = isset($classificationId) && $classificationId > 0 ? " AND classification_id=$classificationId" : "";
        $condition3 = isset($categoryId) && $categoryId > 0 ? " AND category_id=$categoryId" : "";
        $condition4 = isset($subcategoryId) && $subcategoryId > 0 ? " AND subcategory_id=$subcategoryId" : "";
        $condition5 = isset($categorySubcategoryId) && $categorySubcategoryId > 0 ? " AND category_subcategory_id=$categorySubcategoryId" : "";

        $query = "SELECT * FROM v_evaluation_criterion_category_subcategory WHERE evaluation_criterion_name LIKE '%$name%'";
        $query .= $condition1;
        $query .= $condition2;
        $query .= $condition3;
        $query .= $condition4;
        $query .= $condition5;

        return $this->executeQuery($query);
    }

    public function containsEvaluationCriterionCategorySubcategory($evaluationCriterionId, $categorySubcategoryId){
        return !is_null($this->executeQuery("SELECT * FROM evaluation_criterion_category_subcategory WHERE evaluation_criterion_id=$evaluationCriterionId AND category_subcategory_id=$categorySubcategoryId LIMIT 1")[0]);
    }

    public function addEvaluationCriterionCategorySubcategory($evaluationCriterionId, $categorySubcategoryId){
        $this->executeQuery("INSERT INTO evaluation_criterion_category_subcategory (evaluation_criterion_id, category_subcategory_id) VALUES($evaluationCriterionId, $categorySubcategoryId)");
    }

    public function getEvaluationCriterionCategorySubcategory($id){
        return $this->executeQuery("SELECT * FROM v_evaluation_criterion_category_subcategory WHERE id=$id LIMIT 1")[0];
    }

    public function updateEvaluationCriterionCategorySubcategory($id, $evaluationCriterionId, $categorySubcategoryId){
        $this->executeQuery("UPDATE evaluation_criterion_category_subcategory SET evaluation_criterion_id=$evaluationCriterionId, category_subcategory_id=$categorySubcategoryId WHERE id=$id");
    }

    public function removeEvaluationCriterionCategorySubcategory($id){
        $this->executeQuery("DELETE FROM evaluation_criterion_category_subcategory WHERE id=$id");
    }

    private function executeQuery($query){
        try{
            return ($this->contextDb->query($query))->FETCHALL(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            die($e->getMessage());
        }
    }
}
?>