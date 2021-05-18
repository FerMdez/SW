<?php
include('../config.php');
function reRol(){
    if(isset($_SESSION["lastRol"])){
        $_SESSION["rol"] = $_SESSION["lastRol"];
        unset($_SESSION["lastRol"]);
    }
}
reRol();
header("Location: /");
?>