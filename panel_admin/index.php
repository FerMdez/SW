<!DOCTYPE HTML>
<?php 
    session_start();

    include_once('../assets/php/config.php');

    require_once('../panel_admin/panelAdmin.php');
    
    $login=false;
    if(isset($_SESSION["login"]) && $_SESSION["rol"] == "admin") $login = true;
    if(isset($_GET['state'])) {
        $panel = new Panel($_GET['state'], $login);
    }
    else {
        $panel = new Panel('', $login);
    }
    // IMPORTANTE:
    //  VERIFICAR QUE ES ADMIN, SI NO, MOSTRAR MENSAJE DE "ERROR"
    
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

        <!-- Panel -->
        <div class="row">
            <!-- Left Sidebar -->
            <div class="sidebar left">
                <ul>
                    <li>Ver como:</li>
                    <ul>
                        <li><a href="index.php?state=un">Usuario no registrado</a></li>
                        <li><a href="index.php?state=ur">Usuario registrado</a></li>
                        <li><a href="index.php?state=ag">Gerente</a></li>
                    </ul><br />
                    <li>Añadir/Editar/Eliminar:</li>
                    <ul>
                        <li><a href="index.php?state=mc">Cines</a></li>
                        <li><a href="index.php?state=mf">Películas</a></li>
                        <li><a href="index.php?state=md">Promociones</a></li>
                        <li><a href="index.php?state=mg">Gerente</a></li>
                    </ul>
                </ul>
            </div>
            <!-- Contents -->
            <div class="row">
                <div class="column side"></div>
                    <div class="column middle">
                        <?php
                            $template->print_msg();
                            $panel->showPanel();
                        ?>
                    </div>
                    <div class="column side"></div>
                </div>
            </div>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
    </body>

</html>
