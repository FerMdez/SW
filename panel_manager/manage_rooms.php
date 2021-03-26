<?php	
	require('room_dto.php');
	
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