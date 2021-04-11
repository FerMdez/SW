<?php
	require('./includes/room_dto.php');
	require('./includes/session_dto.php');
	require('../panel_admin/includes/film_dto.php');
	require('../panel_admin/includes/film_dao.php');
	
    require_once('./includes/listSessions.php');
    $sessionList = new ListSessions();
	
	$placeholder_date = date("Y-m-d");
	$placeholder_hall = "1";
	$filtered = false;

	if(isset($_POST['submit']))	{
		$sessionList->filterList(1,$_POST["hall"],$_POST["date"]);
		$placeholder_date = $_POST["date"];
		$placeholder_hall = $_POST["hall"];
		$filtered = true;
	}
	
	$sessions = $sessionList->getArray();
							
	$r1 = new RoomDTO(1,20,20,30); //Esto se deberia cambiar por una llamada a una lista de salas
	$r2 = new RoomDTO(2,10,30,30);
	$rooms = array($r1, $r2);							
	echo"
					<form method=\"post\">
						<input type=\"date\" name=\"date\" value=\"". $placeholder_date . "\" min=\"2021-01-01\" max=\"2031-12-31\">
						<select name=\"hall\" class=\"button large\">";
	
	foreach($rooms as $r){ 
		if($r->getid() == $placeholder_hall){
			echo "
							<option value=\"". $r->getid() ." \"selected> Sala ". $r->getid() . "</option>";
		}else{
			echo "
							<option value=\"". $r->getid() ." \"> Sala ". $r->getid() . "</option>";
		}
	}
			
	echo "
						<input type=\"submit\" name=\"submit\" value=\"Filtrar\" class=\"button large\" /> 
				</div>";
?>
				
				<div class="column side"> <?php
	function drawSessions($ses,$bd){
	echo "
					<table class='alt'>
						<thead>
							<tr>
								<th>Hora</th>
								<th>Pelicula</th>
								<th>Formato</th>
								<th>Precio</th>
							</tr>
						</thead>
						<tbody>"; 
		foreach($ses as $s){ 
			$fila =  ($bd->FilmData($s->getIdfilm()))->fetch_assoc();	
		echo "
							<tr>
								<td><a href=\"./?state=edit_session&option=edit\">" . $s->getStartTime() . "</a></td>
								<td><a href=\"./?state=edit_session&option=edit\">" .$fila['tittle']  . "</a></td>
								<td><a href=\"./?state=edit_session&option=edit\">" . $s->getFormat() . "</a></td>
								<td><a href=\"./?state=edit_session&option=edit\">". $s->getSeatPrice() . "</a></td>
							</tr>"; 
		} 
		echo "
						<tbody>
					</table>";	
	}
	if($filtered){
		$bd = new Film_DAO('complucine');
		if($bd){
			drawSessions($sessions,$bd);
			echo "
						<input type=\"submit\" name=\"submit\" value=\"Añadir\" class=\"button large\" formaction=\"./?state=edit_session&option=new\"/>\n";
		}
	}
	echo "					</form>
				</div>";
?>	
				
