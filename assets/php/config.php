<?php
    //Start session:
    session_start();

    //HTML template:
    require_once('./assets/php/template.php');
    $template = new Template();
    $prefix = $template->get_prefix();
?>
