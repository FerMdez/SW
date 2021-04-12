<?php
    session_start();

    require_once('../assets/php/template.php');
    require_once('./includes/formRegister.php');

    $template = new Template();

    $reg = new Register();
    $reg->testReg();
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
                                echo $reg->getReply();
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