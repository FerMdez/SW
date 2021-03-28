<?php	
	require('room_dto.php');
	
	$r1 = new RoomDTO(0,20,20);
	$r2 = new RoomDTO(1,10,30);
	$r3 = new RoomDTO(2,30,10);
	$r4 = new RoomDTO(3,15,15);
	$rooms = array($r1, $r2, $r3, $r4);							

	function drawRooms($ros){
		echo "
		<table class='alt'>
			<thead>
				<tr>
					<th>Sala</th>
					<th>Opción</th>
				</tr>
			</thead>
			<tbody>"; 
		foreach($ros as $r){ 
		echo "
			<tr>
				<!-- AUN NO HEMOS VISTO JAVASCRIPT -->
				<!-- ADEMÁS, AUNQUE USÁSEMOS JS, ESO NO SE HARÍA CON UN WINDOWS.LOCATION.HREF, DE MOMENTO, USAD LOS BOTONES COMO OS PONGO EL DE AÑADIR -->
				<!--<td> <button type=\"button\"> Sala ". $r->getId() ."</button> </td> -->
				<td><a href=\"\" class='button'>Sala". $r->getId() ."</a></td>
				<!--<td> <button type=\"button\" onClick=\"Javascript:window.location.href = 'index.php?edit_rooms=true';\")\">Editar</button> </td> MAL, POR LO MISMO-->
				<td><a href=\"index.php?edit_rooms=true\" class='button'>Editar</a></td>
			</tr>";
		}
		echo "<tbody>
		</table>\n";
	echo "<a href=\"index.php?edit_sessions=true\" class='button large'>Añadir</a>";
	}
	drawRooms($rooms);
?>