<!DOCTYPE HTML>
<?php 
    session_start();

    //HTML template:
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

        <!-- Form -->
        <section id="formulario">
            <h4>Formulario</h4>
            <form method="post" action="mailto:fernmend@ucm.es">
                <div class="row">
                    <fieldset id="datos_personales">
                        <legend>Datos personales</legend>
                        <div class="_name">
                            <input type="text" name="name" id="name" value="" placeholder="Nombre" required/>
                        </div>
                        <div class="_email">
                            <input type="email" name="email" id="email" value="" placeholder="Email" required/>
                        </div>
                    </fieldset>
                    <fieldset id="motivo">
                        <legend>Motivo de la consulta</legend>
                        <div class="reason">
                            <input type="radio" id="radio" name="reason" value="evaluation" checked>
                            <label for="evaluation">Evaluación</label>
                        </div>
                        <div class="reason">
                            <input type="radio" id="radio" name="reason" value="sugestions">
                            <label for="sugestions">Sugerencias</label>
                        </div>
                        <div class="reason">
                            <input type="radio" id="radio" name="reason" value="critics">
                            <label for="critics">Críticas</label>
                        </div>
                    </fieldset>
                    <div class="message">
                        <textarea name="message" id="message" placeholder="Escribe aquí tu mensaje..."></textarea> <!-- rows="5"  -->
                    </div>
                    <div class="verify">
                        <input type="checkbox" id="checkbox" name="terms" required>
                        <label for="terms">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio.</label>
                    </div>
                    <div class="actions"> 
                        <input type="submit" id="submit" value="Enviar mensaje" class="primary" />
                        <input type="reset" id="reset" value="Borrar" />       
                    </div>
                </div>
            </form>
        </section>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
       
    </body>

</html>
