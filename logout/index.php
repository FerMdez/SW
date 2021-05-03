<?php
    header("refresh:4;url=../");

    //General Config File:
    require_once('../assets/php/config.php');
    
    //Session:
	//session_start(); /* Inicializada en config.php */
	unset($_SESSION);
	session_destroy();
	if(!isset($_SESSION["nombre"])){
		$reply = "<h1>Se ha cerrado la sesión</h1><hr />".
                    "<p>Serás redirigido al inicio en unos segundos.<br />
                        Haz clic <a href='{$prefix}'>aquí</a> si tu navegador no te redirige automáticamente.</p>\n";
	}
	else{
		$reply = "<h1>Ha ocurrido un problema y no hemos podido finalizar la sesión</h1>".
					"<p>Serás redirigido al inicio en unos segundos.<br />
                        Haz clic <a href='{$prefix}'>aquí</a> si tu navegador no te redirige automáticamente.</p>\n";
	}

    
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