<?php
if(!Access::isAdministrator()){
    include $_SERVER["DOCUMENT_ROOT"] . "/Views/Renders/MenuCustomer.php";
}
?>