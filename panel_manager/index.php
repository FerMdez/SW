<!DOCTYPE HTML>
<?php 
    session_start();

    require_once('../assets/php/template.php');
    $template = new Template();
	require_once('./session_dto.php');
	require_once('./room_dto.php');
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
		<?php if(isset($_GET['edit_sessions'])){ ?>
			<!-- Edit sessions panels -->
			<p> Esto es solo una prueba para poder diseñar la vista de editar y añadir sesiones. hay 98% de probabilidades de que este mal o no sea optimo la forma de haber llegado a este panel <p>
			<td> <button type="button" onClick="Javascript:window.location.href = 'index.php';")>Volver</button> </td>
			
		<?php } elseif(isset($_GET['edit_rooms'])){ ?>
			<!-- Edit rooms panels -->
			<p> Esto es solo una prueba para poder diseñar la vista de editar y añadir salas. hay 94% de probabilidades de que este mal o no sea optimo la forma de haber llegado a este panel <p>
			<td> <button type="button" onClick="Javascript:window.location.href = 'index.php';")>Volver</button> </td>
			
			
		<?php } else { ?>	
            <!-- Choose Rooms and Date -->
            <div class="column left">
                <input type="date" name="fecha" min="2021-01-01" max="2031-12-31">
                <?php								
                    $r1 = new RoomDTO(0,20,20);
                    $r2 = new RoomDTO(1,10,30);
                    $r3 = new RoomDTO(2,30,10);
                    $r4 = new RoomDTO(3,15,15);
                    $rooms = array($r1, $r2, $r3, $r4);							
                    
                    function drawRooms($ros){
                        echo "<table>"; 
                        foreach($ros as $r){ 
                        echo "
                    <tr>
                        <td> <button type=\"button\"> Sala ". $r->getId() ."</button> </td>
                        <td> <button type=\"button\" onClick=\"Javascript:window.location.href = 'index.php?edit_rooms=true';\")\">Editar</button> </td>
                    </tr>";
                        }
                        echo "
                        <tr>
                            <td> <button type=\"button\" onClick=\"Javascript:window.location.href = 'index.php?edit_rooms=true';\")\">Añadir</button> </td>
                        </tr>
                </table>\n";
                    }
                    
                    drawRooms($rooms);
				?>
            </div>
            <!-- Sessions List -->
            <div class="row">
				<div class="column left">
					<?php		
							
					$s1 = new SessionDTO(0,"HOY","10:00","9,99€","normal","Los vengativos: final del juego");
					$s2 = new SessionDTO(1,"HOY","12:00","10€","3D","Los vengativos: final del juego");
					$s3 = new SessionDTO(2,"HOY","14:00","10€","subtitulado","Los vengativos: final del juego");
					$s4 = new SessionDTO(3,"HOY","16:00","9,99€","normal","Los vengativos: final del juego");
					$s5 = new SessionDTO(4,"HOY","18:00","9,99€","normal","Los vengativos: final del juego");
					$s6 = new SessionDTO(5,"HOY","20:00","20€","4D","Los vengativos: final del juego");
					$sessions = array($s1, $s2, $s3, $s4, $s5, $s6);							
							
					function drawSessions($ses){
					
						echo "<table>"; 
							foreach($ses as $s){ 
							echo "
								<tr>
									<td>" . $s->getStartTime() . "</td>
									<td>" . $s->getFilm() . "</td>
									<td>" . $s->getFormat() . "</td>
									<td>". $s->getSeatPrice() . "</td>
									<td> <button type=\"button\" onClick=\"Javascript:window.location.href = 'index.php?edit_sessions=true';\")\">Editar</button> </td>
								</tr>"; 
							} 
							echo "
								<tr>
									<td> <button type=\"button\" onClick=\"Javascript:window.location.href = 'index.php?edit_sessions=true';\")\">Añadir</button> </td>
								</tr>
					</table>";
					}
					drawSessions($sessions);
					?>
                    
				</div>
				<div class="column side"></div>
			</div>
			<?php }  ?>	

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
       
    </body>

</html>
