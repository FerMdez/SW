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
        
             <!--Left Sidebar --> 
			<div class="sidebar left">
                <ul>
                    <li>Ver como:</li>
                    <ul>
                        <li><a href='./?state=us_u'>Usuario no registrado</a></li>
                        <li><a href='./?state=us_r'>Usuario registrado</a></li>
                    </ul><br />
                    <li>Añadir/Editar/Eliminar:</li>
                    <ul>
                        <li><a href='./?state=rooms'>Salas</a></li>
                        <li><a href='./?state=sessions'>Sesiones</a></li>
                    </ul>
                </ul>
            </div>
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
