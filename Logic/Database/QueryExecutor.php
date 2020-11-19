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

    public function getStreets($countryId, $regionId, $cityId, $name){
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