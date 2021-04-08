<!DOCTYPE HTML>
<?php 
    session_start();

    require_once('../assets/php/template.php');
	require_once('./panel_manager.php');
    
	$template = new Template();

	if(isset($_REQUEST['state'])) {
        $panel = new Panel($_REQUEST['state']); //CHICOS, UNA CLASE CREADA ASÍ ESTÁ HORRIBLE, ADEMÁS NO SÉ QUÉ FUNCIÓN TIENE EXCACTAMENTE ESTA CLASE, PERO DEBÉIS REHACERLA
    }
    else {
        $panel = new Panel('');  //ESTO NO PUEDE SER ASÍ
    }
    // IMPORTANTE:
    //  VERIFICAR QUE ES MANAGER(GERENTE), SI NO, MOSTRAR MENSAJE DE "ERROR"
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
            <!-- Left Sidebar -->
			<div class="sidebar left">
                <ul>
                    <li>Ver como:</li>
                    <ul>
                        <li><a href="index.php?state=us_u">Usuario no registrado</a></li>
                        <li><a href="index.php?state=us_r">Usuario registrado</a></li>
                    </ul><br />
                    <li>Añadir/Editar/Eliminar:</li>
                    <ul>
                        <li><a href="index.php?state=rooms">Salas</a></li>
                        <li><a href="index.php?state=sessions">Películas</a></li>
                    </ul>
                </ul>
            </div>
            <!-- Contents -->
            <div class="row">
                <div class="column middle">
					<?php
						if(isset($_GET['edit_rooms']) == "true"){ 
							echo "<p> Esto esta editando </p>";
							if(isset($_GET['new_rooms']) == "true"){ 
								echo "<p> Ademas es nueva </p>";
							}
						echo "</div>";
						} else {
							$panel->showPanel();
						}
					?>
				
			</div>
        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
       
    </body>

</html>
