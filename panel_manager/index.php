<!DOCTYPE HTML>
<?php 
    session_start();

    require_once('../assets/php/template.php');
    $template = new Template();

    // IMPORTANTE:
    //  VERIFICAR QUE ES MANAGER(GERENTE), SI NO, MOSTRAR MENSAJE DE "ERROR"
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
                        <li>Subfuncionalidad</li>
                        <li>Subfuncionalidad</li>
                    </ul><br />
                    <li>Ver como:</li>
                    <ul>
                        <li>Usuario no registrado</li>
                        <li>Usuario registrado</li>
                        <li>Gerente</li>
                    </ul><br />
                    <li>Añadir/Editar/Eliminar:</li>
                    <ul>
                        <li>Cines</li>
                        <li>Películas</li>
                        <li>Promociones</li>
                        <li>Gerente</li>
                    </ul>
                </ul>
            </div>
            <!-- Contents -->
            <div class="row">
                <div class="column side"></div>
                    <div class="column middle">
                        <h2>AQUÍ EL CONTENIDO DE CADA FUNCIONALIDAD.</h2>
                        <p>Debe variar dinámicamente según el botón del panel izquierdo que se pulse (sin cargar una página diferente, aunque tendrá que recargar el contido, eso sí).</p>
                        <p>Tendréis que rehacer todo el "PANEL" con PHP.</p>
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
