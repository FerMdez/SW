<?php
    session_start();

    //Depuración (BORRAR):
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //HTML template:
    require_once('../assets/php/template.php');
    $template = new Template();

    //Login form validate:
    require_once('./includes/formLogin.php');
    $login = new FormLogin();
    $login->processesForm($_POST["name"], $_POST["pass"]);
    $reply = $login->getReply();

?>
<!DOCTYPE HTML>
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
        <div class="main">
            <div class="image"><img src="../img/logo_trasparente.png" /></div>
        </div>
        
        <!-- Reply -->
        <section class="reply">
            <div class ="row">
                <div class="column side"></div>
                <div class="column middle">
                    <div class="code info">
                        <?php
                            echo $reply;
                        ?>
                    </div>
                </div>
                <div class="column side"></div>    
            </div>
        </section>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>

    </body>

</html>