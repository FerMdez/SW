<!DOCTYPE HTML>
<?php 
    session_start();

    require_once('../assets/php/template.php');
    $template = new Template();

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
                <li>Funcionalidad:</li>
                    <ul>
                        <li>Subfuncionalidad</li>
                        <li>Subfuncionalidad</li>
                    </ul><br />
                    <li>Ver como:</li>
                    <ul>
                        <li>Usuario no registrado</li>
                        <li>Usuario registrado</li>
                        <li>Gerente</li>
                    </ul><br />
                    <li>Añadir/Editar/Eliminar:</li>
                    <ul>
                        <li>Cines</li>
                        <li>Películas</li>
                        <li>Promociones</li>
                        <li>Gerente</li>
                    </ul>
                </ul>
            </div>
            <!-- Contents -->
            <div class="row">
                <div class="column side"></div>
                    <div class="column side">
                        <?php
							class Session {
								public $hour;
								public $title;
								public $format;
								public $lang;
							}			

							$s1 = new Session();
							$s1->hour = '10:00';
							$s1->title = 'Los vengativos:final del juego';
							$s1->format = 'Comic Sans';
							$s1->lang = 'Castellano';
							
							
							$s2 = new Session();
							$s2->hour = '12:00';
							$s2->title = 'Los vengativos:final del juego';
							$s2->format = 'Comic Sans';
							$s2->lang = 'Castellano';
							
							$s3 = new Session();
							$s3->hour = '14:00';
							$s3->title = 'Los vengativos:final del juego';
							$s3->format = 'Comic Sans';
							$s3->lang = 'Castellano';


							$sessions = array($s1, $s2, $s3);							
							$num_s = 3; 
							
							function drawSessions($ses){
							echo "<table border='1'>"; 

								foreach($ses as $s){ 
								echo "<tr>"; 
								
									echo "<td> <td align='center'>". $s->hour."</td>"; 
									echo "<td> <td align='center'>". $s->title."</td>"; 
									echo "<td> <td align='center'>". $s->format."</td>"; 
									echo "<td> <td align='center'>". $s->lang."</td>"; 
									echo "<td> <td align='center'> <button type=\"button\">Editar</button> </td>"; 
									echo "</tr>"; 
									
								} 
								echo "<tr>"; 
								echo "<td> <td align='center'> <button type=\"button\">Añadir</button> </td>"; 
								echo "</tr>"; 
							echo "</table>";
							}
							
							drawSessions($sessions);
						?>
                    </div>
                    <div class="column side"></div>
                </div>
            </div>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
       
    </body>

</html>
