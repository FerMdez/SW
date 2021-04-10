<?php
	require('./includes/room_dto.php');
	require('./includes/session_dto.php');
	
	//Login form validate:
    require_once('./includes/listSessions.php');
    $sessionList = new ListSessions("1", "1", "2021-04-10");

?>			
				<input type="date" name="fecha" min="2021-01-01" max="2031-12-31">
					<?php								
							$r1 = new RoomDTO(0,20,20,30);
							$r2 = new RoomDTO(1,10,30,30);
							$r3 = new RoomDTO(2,30,10,30);
							$r4 = new RoomDTO(3,15,15,30);
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
						$sessionList->filterList();
						$sessions = $sessionList->getArray();						
									
						function drawSessions($ses){
						
						echo "
						<table class='alt'>
							<thead>
								<tr>
									<th>Hora</th>
									<th>idPelícula</th>
									<th>Formato</th>
									<th>Precio</th>
								</tr>
							</thead>
							<tbody>"; 
							foreach($ses as $s){ 
							echo "
										
										<tr>
											
												<td><a href=\"./?state=edit_session&option=edit\">" . $s->getStartTime() . "</a></td>
												<td><a href=\"./?state=edit_session&option=edit\">" . $s->getIdfilm() . "</a></td>
												<td><a href=\"./?state=edit_session&option=edit\">" . $s->getFormat() . "</a></td>
												<td><a href=\"./?state=edit_session&option=edit\">". $s->getSeatPrice() . "</a></td>
											 
										</tr>"
			; 
							} 
							echo "<tbody>
							</table>\n";
							echo "<a href=\"./?state=edit_session&option=new\" class='button large'>Añadir</a>";
						}
						drawSessions($sessions);
					?>	
				</div>
