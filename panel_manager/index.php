<!DOCTYPE HTML>
<?php 
	//General Config File:
    require_once('../assets/php/config.php');
	
	include_once('panel_manager.php');
	
    $login = false;

    if(isset($_SESSION["login"]) && $_SESSION["rol"] == "manager") $login = true;

	if(isset($_REQUEST['state'])) {
        $panel = new Panel($_REQUEST['state'],$login); 
    }
    else { 
        $panel = new Panel('',$login); 
    }
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
                $template->print_panelMenu("manager");
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
