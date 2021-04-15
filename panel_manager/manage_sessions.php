<?php
	//General Config File:
    require_once('../assets/php/config.php');
	
	include_once('./includes/hall_dto.php');
	include_once('./includes/formHall.php');	
	
	include_once('./includes/session_dto.php');
	include_once('./includes/formSession.php');	
	
	include_once('../panel_admin/includes/film_dto.php');
	include_once('../panel_admin/includes/film_dao.php');
	
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
		
	echo"				
				<!--Session Filter -->
				<div class = \"column middle\"> 
					<form method=\"post\" id=\"addfilter\">	
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
						</select>
						<input type=\"submit\" name=\"filter\" value=\"Filtrar\" class=\"button large\" /> 
					</form>
				</div>";
				
	function drawSessions($sessions,$bd){
	echo "			<!--Session List -->
					<div class=\"column side\">
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
									<form method=\"post\" action=\"./?state=edit_session&option=edit\">
									
										<input  name=\"id\" type=\"hidden\" value=\"".$s->getId()."\">
										<input  name=\"idfilm\" type=\"hidden\" value=\"".$s->getIdfilm()."\">
										<input  name=\"idhall\" type=\"hidden\" value=\"".$s->getIdhall()."\">
										<input  name=\"idcinema\" type=\"hidden\" value=\"".$s->getIdcinema()."\">
										<input  name=\"date\" type=\"hidden\" value=\"".$s->getDate()."\">
										<input  name=\"start\" type=\"hidden\" value=\"".$s->getStartTime()."\">
										<input  name=\"price\" type=\"hidden\" value=\"".$s->getSeatPrice()."\">
										<input  name=\"format\" type=\"hidden\" value=\"".$s->getFormat()."\">
										
									<td> <input type=\"submit\" id=\"submit\" value=\"Editar\" class=\"button\" > </td>
									</form>
								</tr>"; 
		} 
		echo "
							<tbody>
						</table>
						<input type=\"submit\" name=\"submit\" form=\"addfilter\"  value=\"Añadir\" class=\"button large\" formaction=\"./?state=edit_session&option=new\">
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
		echo "
		
				<div class=\"column side\">
					<p> No hay ninguna session en la sala ". $placeholder_hall . " el dia ". $placeholder_date . "</p>
					<input type=\"submit\" name=\"submit\" form=\"addfilter\"  value=\"Añadir\" class=\"button large\" formaction=\"./?state=edit_session&option=new\">
				</div>";
	}
?>	