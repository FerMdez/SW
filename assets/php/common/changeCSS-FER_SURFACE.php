<?php
    include('../../../assets/php/config.php');

    switch(true){
        case strpos($_GET["css"], "main.css"): $_SESSION["css"] = "main.css"; break;
        case strpos($_GET["css"], "highContrast.css"): $_SESSION["css"] = "highContrast.css"; break;
        default: $_SESSION["css"] = "main.css"; break;
    }
?>