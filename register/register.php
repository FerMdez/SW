<?php
    //General Config File:
    require_once('../assets/php/config.php');
    
    //Login form validate:
    require_once('./includes/formRegister.php');
    //$register = new FormRegister();
    //$register->processesForm($_POST["name"], $_POST["email"], $_POST["pass"], $_POST["repass"]);
    $reply = FormRegister::getReply();

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