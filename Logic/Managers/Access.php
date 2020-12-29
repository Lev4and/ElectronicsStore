<?php
class Access{
    public static function isAuthorized(){
        return (isset($_SESSION["user"]) && count($_SESSION["user"]) > 0 && $_SESSION["user"]["id"] > 0);
    }

    public static function isAdministrator(){
        return (isset($_SESSION["user"]) && count($_SESSION["user"]) > 0 && $_SESSION["user"]["role_name"] == "Администратор");
    }

    public static function denyAuthorization(){
        VisibleError::showError("Вы уже авторизованы.");
    }

    public static function denyRegistration(){
        VisibleError::showError("Вы не можете зарегистрироваться, так как вы авторизованы.");
    }

    public static function denyAccess(){
        VisibleError::showError("У вас нет прав доступа на посещение данной страницы.");
    }
}
?>