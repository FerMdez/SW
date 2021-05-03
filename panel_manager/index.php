<!DOCTYPE HTML>
<?php 
	//General Config File:
    require_once('../assets/php/config.php');
	
	include_once('panel_manager.php');
	
	$login = (isset($_SESSION["login"]) && $_SESSION["rol"] == "manager") ? true : false;
	$panel = isset($_REQUEST['state']) ? new Panel($_REQUEST['state'],$login) : $panel = new Panel('',$login); 

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
                $template->print_panelMenu($_SESSION["rol"]);
            ?>
            <!--Contents -->
            <div class="row"> 
				<?php $panel->showPanel(); ?>
			</div>
        </div>
        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
       
    </body>

</html>
