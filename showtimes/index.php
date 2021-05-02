<!DOCTYPE HTML>
<?php
    //General Config File:
    require_once('../assets/php/config.php');
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

        <!-- Films -->
        <section id="films_billboard">
            <div class='row'>
                <?php
                    $template->print_fimls();
                ?>
            </div>
        </section>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
       
    </body>

</html>
