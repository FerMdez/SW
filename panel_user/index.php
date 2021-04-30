<!DOCTYPE HTML>
<?php 
    //General Config File:
    require_once('../assets/php/config.php');

    // IMPORTANTE:
    //  VERIFICAR QUE EL USUARIO HA INICIADO SESIÓN, SI NO, MOSTRAR MENSAJE DE "ERROR"
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
            <!-- Panel Menu -->
            <?php
                $template->print_panelMenu("user");
            ?>
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
