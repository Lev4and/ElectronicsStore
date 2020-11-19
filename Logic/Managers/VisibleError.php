<?php
class VisibleError{

    public static function showError($message = null){
        if(!is_null($message)){
            $_SESSION["error"] = $message;
        }

        include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/Error.php";
        $_SESSION["error"] = "";
    }
}
?>

