<?php
    //General Config File:
    include_once('../assets/php/config.php');
    
    require_once($prefix.'panel_admin/panelAdmin.php');

    $login=false;
    if(isset($_SESSION["login"]) && $_SESSION["rol"] == "admin") $login = true;
    if(isset($_GET['state'])) {
        $panel = new Panel($_GET['state'], $login);
    }
    else {
        $panel = new Panel('', $login);
    }
    
?>
<!DOCTYPE HTML>
<!--
    Práctica - Sistemas Web | Grupo D
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

        <!-- Panel -->
        <div class="row">
           <!-- Panel Menu -->
           <?php
                $template->print_panelMenu($_SESSION["rol"]);
            ?>
            <!-- Contents -->
            <div class="row">
            <?php
                $template->print_msg();
                $panel->showPanel($template);
            ?>
            </div>
        </div>
        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
    </body>

</html>
