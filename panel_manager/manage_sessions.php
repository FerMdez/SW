<?php
	require('room_dto.php');
	require('session_dto.php');
?>			
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
							</tr>";
								}
								echo "
						</table>\n";
							}
							drawRooms($rooms);
					?>
				</div>
				<div class="column side">
					<?php				
						$s1 = new SessionDTO(0,"HOY","10:00","9,99€","normal","Los vengativos: final del juego");
						$s2 = new SessionDTO(1,"HOY","12:00","10€","3D","Los vengativos: final del juego");
						$s3 = new SessionDTO(2,"HOY","14:00","10€","subtitulado","Los vengativos: final del juego");
						$s4 = new SessionDTO(3,"HOY","16:00","9,99€","normal","Los vengativos: final del juego");
						$s5 = new SessionDTO(4,"HOY","18:00","9,99€","normal","Los vengativos: final del juego");
						$s6 = new SessionDTO(5,"HOY","20:00","20€","4D","Los vengativos: final del juego");
						$sessions = array($s1, $s2, $s3, $s4, $s5, $s6);							
								
						function drawSessions($ses){
						
						echo "
						<table class='alt'>
							<thead>
								<tr>
									<th>Hora</th>
									<th>Película</th>
									<th>Tipo</th>
									<th>Precio</th>
									<!-- <th>Opción</th> --> <!-- HAY QUE ELIMINAR ESTA COLUMNA, COMO EXPLICÓ IVÁN EN CLASE, -->
																<!-- LAS TABLAS TIENEN EL PROBLEMA DE QUE CON MUCHAS COLUMNAS SE EXPANDEN FUERA DE LOS LÍMITES -->
								</tr>
							</thead>
							<tbody>"; 
							foreach($ses as $s){ 
							echo "
									<tr>
										<td>" . $s->getStartTime() . "</td>
										<td>" . $s->getFilm() . "</td>
										<td>" . $s->getFormat() . "</td>
										<td>". $s->getSeatPrice() . "</td>
										<!-- <td> <button type=\"button\" onClick=\"Javascript:window.location.href = 'index.php?edit_sessions=true';\")\">Editar</button> </td> --> 
														<!-- LA SOLUCIÓN PUEDE SER PONER EN ELACE DE EDICIÓN EN CADA UNO DE LOS ELEMENTOS DE LA COLUMNA -->
									</tr>"; 
							} 
							echo "<tbody>
							</table>\n";
							echo "<a href=\"index.php?state=edit_session&option=new\" class='button large'>Añadir</a>";
						}
						drawSessions($sessions);
					?>	
				</div>