<?php	
	require('./includes/hall_dto.php');
	
	$r1 = new HallDTO(0,20,20,30);
	$r2 = new HallDTO(1,10,30,30);
	$r3 = new HallDTO(2,30,10,30);
	$r4 = new HallDTO(3,15,15,30);
	$rooms = array($r1, $r2, $r3, $r4);							

	function drawHalls($ros){
		echo " <p> Esta vista esta en desarrollo <p>
	<div class=\"column middle\">
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
				<td><a href=\"\" class='button'>Sala". $r->getNumber() ."</a></td>
				<td><a href=\"index.php?state=rooms\" class='button'>Editar</a></td>
			</tr>";
		}
		echo "<tbody>
		</table>\n";
	echo "<a href=\"index.php?state=rooms\" class='button large'>Añadir</a>
	</div>";
	}
	drawHalls($rooms);
?>

