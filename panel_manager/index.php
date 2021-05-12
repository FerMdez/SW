<?php

	ini_set('display_errors', 0);
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

    //General Config File:
    require_once('../assets/php/config.php');
    //Controller file:
    include_once('panel_manager.php');
	
    if($_SESSION["login"] && $_SESSION["rol"] === "manager"){
		$_SESSION["cinema"] = 1;
        switch($_GET["state"]){
			case "view_ruser":
			case "view_user":
                   $panel = '<div class="column side"></div>
                   <div class="column middle">
						<div class="code info">
                            <h1>Esta vista aun no esta implementada.</h1><hr />
						</div>
					</div>
                <div class="column side"></div>'."\n";
                break;			
			case "manage_halls":
                $panel = Manager_panel::manage_halls();
                break;
			case "new_hall":
                $panel = Manager_panel::new_hall();
                break;	
			case "edit_hall":
                $panel = Manager_panel::edit_hall();
                break;	
            case "manage_sessions":
                $panel = Manager_panel::manage_sessions();
                break;
			case "new_session":
                $panel = Manager_panel::new_session();
                break;
			case "edit_session":
                $panel = Manager_panel::edit_session();
                break;
			case "select_film":
                $panel = Manager_panel::select_film($template);
                break;
			case "success":
                $panel = Manager_panel::success();
                break;
            default:  
                $panel = Manager_panel::welcome();
                break;
        }
    }
    else{
        $panel = '<div class="column side"></div>
                   <div class="column middle">
						<div class="code info">
                            <h1>Debes iniciar sesión para ver el Panel de Manager.</h1><hr />
                            <p>Inicia Sesión en una cuenta con permisos.</p>
                            <a href="'.$prefix.'login/" ><button class="button large">Iniciar Sesión</button></a>
						</div>
					</div>
                <div class="column side"></div>'."\n";
    }
?>
<!DOCTYPE HTML>
<!--
    Práctica - Sistemas Web | Grupo D
    CompluCine - FDI-cines
-->
<html lang="es">
<link id='estilo' rel='stylesheet' type='text/css' href='../assets/css/manager.css'>
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
            <?php $template->print_panelMenu($_SESSION["rol"]); ?>
		</div>
            <!--Contents -->
        <div class="row"> 
			<?php echo $panel; ?>
		</div>
        
        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
       
    </body>

</html>
