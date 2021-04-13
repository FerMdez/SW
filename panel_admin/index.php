<!DOCTYPE HTML>
<?php 
    session_start();

    require_once('../assets/php/template.php');
    require_once('../panel_admin/panelAdmin.php');
    $template = new Template();
   
    if(isset($_SESSION["login"]) && $_SESSION["rol"] == "admin") $login = true;

    if(isset($_REQUEST['state'])) {
        $panel = new Panel($_REQUEST['state']);
    }
    else {
        $panel = new Panel('');
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
                <li>Funcionalidad:</li>
                    <ul>
                        <li><a href="index.php?state=">Subfuncionalidad </a></li>
                        <li><a href="index.php?state=">Subfuncionalidad</a></li>
                    </ul><br />
                    <li>Ver como:</li>
                    <ul>
                        <li><a href="index.php?state=">Usuario no registrado</a></li>
                        <li><a href="index.php?state=">Usuario registrado</a></li>
                        <li><a href="index.php?state=">Gerente</a></li>
                    </ul><br />
                    <li>Añadir/Editar/Eliminar:</li>
                    <ul>
                        <li><a href="index.php?state=mc">Cines</a></li>
                        <li><a href="index.php?state=mf">Películas</a></li>
                        <li><a href="index.php?state=">Promociones</a></li>
                        <li><a href="index.php?state=">Gerente</a></li>
                    </ul>
                </ul>
            </div>
            <!-- Contents -->
            <div class="row">
                <div class="column side"></div>
                    <div class="column middle">
                        <?php
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
