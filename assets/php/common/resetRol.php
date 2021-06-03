<?php
include('../config.php');
function reRol(){
    if(isset($_SESSION["lastRol"])){
        $_SESSION["rol"] = $_SESSION["lastRol"];
        unset($_SESSION["lastRol"]);
        unset($_SESSION["cinema"]);
    }
}
reRol();
$redirect = ROUTE_APP.'panel_'.$_SESSION['rol'];
header("Location: {$redirect}");
?>