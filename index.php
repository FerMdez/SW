<?php
    //General Config File:
    require_once(__DIR__.'/assets/php/config.php');

    
?>
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
        <main>
            <div class="image"><a href='./'><img src="./img/logo_trasparente.png" alt="logo_FDI-Cines" /></a></div>
            <?php
                if(isset($_SESSION["nombre"])){
                    echo "<h1>Bienvenido {$_SESSION["nombre"]}</h1>\n";
                }
                else{
                    echo "<h1>Bienvenido a CompluCine</h1>\n";
                }
            ?>
            <hr />
        </main>
        
        <!-- Undercard -->
        <section id="cartelera">
            <div class="row">
                <div class="code">
                    <?php
                        $template->print_fimls();
                    ?>
                </div>
            </div>
        </section>
        

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
    </body>

</html>
