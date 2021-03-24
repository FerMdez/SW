<!DOCTYPE HTML>
<?php 
    session_start(); 
    require_once('../assets/php/template.php');
    $template = new Template();
?>
<!--
    Práctica 2 - Sistemas Web | Grupo D
    CompluCine - FDI-cines
-->
<html lang="es">
    <!-- Head -->
    <?php
        $template->print_head();
    ?>
    <body>
        <!-- Header -->
        <?php
            $template->print_header();
        ?>

        <!-- Main -->
        <?php
            $template->print_main();
        ?>        

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
    </body>

</html>