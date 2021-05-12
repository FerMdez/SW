<!--
    Práctica - Sistemas Web | Grupo D
    CompluCine - FDI-cines
-->
<!DOCTYPE HTML>
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

        <!-- Section -->
        <?php
            $template->print_section($section);
        ?>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
       
    </body>
</html>