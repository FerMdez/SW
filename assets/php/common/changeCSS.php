<?php
    include('../../../assets/php/config.php');

    if($_GET["css"] === "main.css") $_SESSION["css"] = "main.css";
    else if($_GET["css"] === "highContrast.css") $_SESSION["css"] = "highContrast.css";
?>