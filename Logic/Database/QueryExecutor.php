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