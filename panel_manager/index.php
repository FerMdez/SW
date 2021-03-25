OCTYPE HTML>
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
                    <div class="column left">
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
							
							$s4 = new Session();
							$s4->hour = '16:00';
							$s4->title = 'Los vengativos:final del juego';
							$s4->format = 'Comic Sans';
							$s4->lang = 'Castellano';
							
							$s5 = new Session();
							$s5->hour = '18:00';
							$s5->title = 'Los vengativos:final del juego';
							$s5->format = 'Comic Sans';
							$s5->lang = 'Castellano';
							
							$s6 = new Session();
							$s6->hour = '20:00';
							$s6->title = 'Los vengativos:final del juego';
							$s6->format = 'Comic Sans';
							$s6->lang = 'Castellano';
							
							$s7 = new Session();
							$s7->hour = '22:00';
							$s7->title = 'Los vengativos:final del juego';
							$s7->format = 'Comic Sans';
							$s7->lang = 'Castellano';
							
							$s8 = new Session();
							$s8->hour = '23:59';
							$s8->title = 'Los vengativos:final del juego';
							$s8->format = 'Comic Sans';
							$s8->lang = 'Castellano';

							$sessions = array($s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8);							
							
							function drawSessions($ses){
							echo "<div class=\"table_container\">";
							echo "<table border='1'>"; 
								foreach($ses as $s){ 
									echo "<tr>"; 
									
									echo "<td> <td align='center'>". $s->hour."</td>"; 
									echo "<td> <td align='center'>". $s->title."</td>"; 
									echo "<td> <td align='center'>". $s->format."</td>"; 
									echo "<td> <td align='center'>". $s->lang."</td>"; 
									echo "<td> <td align='center'><button type=\"button\">Editar</button></td>"; 
									
									echo "</tr>"; 
									
								} 
							echo "<tr>"; 
							echo "<td> <td align='center' colspan=\"9\"> <button type=\"button\">Añadir</button> </td>"; 
							echo "</tr>"; 
							
							echo "</table>";
							echo "</div>";
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
