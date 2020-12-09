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
        return $this->executeQuery("SELECT * FROM category WHERE id=$id LIMIT 1")[0];
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

    public function getUnits($name){
        return $this->executeQuery("SELECT * FROM unit WHERE name LIKE '%$name%'");
    }

    public function containsUnit($name, $designation){
        return !is_null($this->executeQuery("SELECT * FROM unit WHERE name='$name' AND designation='$designation' LIMIT 1")[0]);
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

    public function getCharacteristicsCategorySubcategory($classificationId = null, $categoryId = null, $subcategoryId = null, $categorySubcategoryId = null, $characteristicId = null, $name){
        $condition1 = isset($classificationId) && $classificationId > 0 ? " AND classification_id=$classificationId" : "";
        $condition2 = isset($categoryId) && $categoryId > 0 ? " AND category_id=$categoryId" : "";
        $condition3 = isset($subcategoryId) && $subcategoryId > 0 ? " AND subcategory_id=$subcategoryId" : "";
        $condition4 = isset($categorySubcategoryId) && $categorySubcategoryId > 0 ? " AND category_subcategory_id=$categorySubcategoryId" : "";
        $condition5 = isset($characteristicId) && $characteristicId > 0 ? " AND characteristic_id=$characteristicId" : "";

        $query = "SELECT * FROM v_characteristic_category_subcategory WHERE characteristic_name LIKE '%$name%'";
        $query .= $condition1;
        $query .= $condition2;
        $query .= $condition3;
        $query .= $condition4;
        $query .= $condition5;

        return $this->executeQuery($query);
    }

    public function containsCharacteristicCategorySubcategory($characteristicId, $categorySubcategoryId){
        return !is_null($this->executeQuery("SELECT * FROM characteristic_category_subcategory WHERE characteristic_id=$characteristicId AND category_subcategory_id = $categorySubcategoryId LIMIT 1")[0]);
    }

    public function addCharacteristicCategorySubcategory($characteristicId, $categorySubcategoryId){
        $this->executeQuery("INSERT INTO characteristic_category_subcategory (characteristic_id, category_subcategory_id) VALUES ($characteristicId, $categorySubcategoryId)");
    }

    public function getCharacteristicCategorySubcategory($id){
        return $this->executeQuery("SELECT * FROM v_characteristic_category_subcategory WHERE id=$id LIMIT 1")[0];
    }

    public function updateCharacteristicCategorySubcategory($id, $characteristicId, $categorySubcategoryId){
        $this->executeQuery("UPDATE characteristic_category_subcategory SET characteristic_id=$characteristicId, category_subcategory_id=$categorySubcategoryId WHERE id=$id");
    }

    public function removeCharacteristicCategorySubcategory($id){
        $this->executeQuery("DELETE FROM characteristic_category_subcategory WHERE id=$id");
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