<!DOCTYPE HTML>
<!--
    Práctica 2 - Sistemas Web | Grupo D
    CompluCine - FDI-cines
-->
<html lang="es">
    <head>
        <title>CompluCine | Contacto</title>
        <meta charset="utf-8" />
        <link id="estilo" rel="stylesheet" type="text/css" href="../assets/css/main.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../img/favicon.png" />
    </head>
    <body>
        <!-- Header -->
        <?php
            require_once('../assets/php/header.php');
        ?>

        <!-- Main -->
        <div class="main">
            <div class="image"><img src="../img/logo_trasparente.png" /></div>
            <h1>Contacto</h1>
            <hr />
        </div>

        <!-- Form -->
        <section id="formulario">
            <h4>Formulario</h4>
            <form method="post" action="mailto:fernmend@ucm.es">
                <div class="row">
                    <fieldset id="datos_personales">
                        <legend>Datos personales</legend>
                        <div class="_name">
                            <input type="text" name="name" id="name" value="" placeholder="Nombre" />
                        </div>
                        <div class="_email">
                            <input type="email" name="email" id="email" value="" placeholder="Email" />
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
                        <input type="checkbox" id="checkbox" name="terms">
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
            include_once('../assets/php/footer.php');
        ?>
       
    </body>

</html>
