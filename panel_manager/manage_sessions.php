<?php
	require('./includes/hall_dto.php');
	require('./includes/formHall.php');	
	
	require('./includes/session_dto.php');
	require('./includes/formSession.php');	

	require_once('../assets/php/template.php');
    $template = new Template();
    $prefix = $template->get_prefix();
	
	require($prefix.'panel_admin/includes/film_dto.php');
	require($prefix.'/panel_admin/includes/film_dao.php');
	
	$formSession = new FormSession();	
	$formHall = new FormHall();
	
	$placeholder_date = date("Y-m-d");
	$placeholder_hall = "1";
	$cinema = "1";

	if(isset($_POST['filter']))	{
		$placeholder_date = $_POST["date"];
		$placeholder_hall = $_POST["hall"];
	}
	
	$formHall->processesForm(null, $cinema, null, null, "list");
	$formSession->processesForm(null, null, $placeholder_hall, $cinema, $placeholder_date, null, null, null, null, "list");
		
	echo"				<form method=\"post\">	
					<!--Session Filter -->
					<div class = \"column left\"> 
						<input type=\"date\" name=\"date\" value=\"". $placeholder_date . "\" min=\"2021-01-01\" max=\"2031-12-31\">
						<select name=\"hall\" class=\"button large\">";
	
	foreach($formHall->getReply() as $r){ 
		if($r->getNumber() == $placeholder_hall){
			echo "
							<option value=\"". $r->getNumber() ." \"selected> Sala ". $r->getNumber() . "</option>";
		}else{
			echo "
							<option value=\"". $r->getNumber() ." \"> Sala ". $r->getNumber() . "</option>";
		}
	}
			
	echo "
						<input type=\"submit\" name=\"filter\" value=\"Filtrar\" class=\"button large\" /> 
					</div>";
	function drawSessions($sessions,$bd){
	echo "			<!--Session List -->
					<div class=\"column right\">
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
		foreach($sessions as $s){ 
			$film = mysqli_fetch_array($bd->FilmData($s->getIdfilm()));
		echo "
								<tr>
									<td> " . date('H:i', strtotime( $s->getStartTime()))  . "</a></td>
									<td> " . str_replace('_', ' ', $film["tittle"])  . "</a></td>
									<td> " . $s->getFormat() . "</a></td>
									<td> " . $s->getSeatPrice() . "</a></td>
									<td> <input type=\"submit\" name=\"submit\" value=\"Editar\" class=\"button\" formaction=\"./?state=edit_session&option=edit&id=". $s->getid() ."\"/> </td>
								</tr>"; 
		} 
		echo "
							<tbody>
						</table>
						<input type=\"submit\" name=\"submit\" value=\"Añadir\" class=\"button large\" formaction=\"./?state=edit_session&option=new\">
					</div>";	
		
	}
	if($formSession->getReply()){
		$bd = new Film_DAO('complucine');
		if($bd){
			drawSessions($formSession->getReply(), $bd);
		} else {
			echo "<div class=\"column side\">
				<p> Hay un error en la conexion </p>
				</div>";
		}
	} else {
		echo "<div class=\"column side\">
				<p> No hay ninguna session en la sala ". $placeholder_hall . " el dia ". $placeholder_date . "</p>
				<input type=\"submit\" name=\"submit\" value=\"Añadir\" class=\"button large\" formaction=\"./?state=edit_session&option=new\">
		</div>";
	}
	echo "	
					
				</form>";
?>	
				
