<?php
	require('./includes/hall_dto.php');
	require('./includes/formHall.php');	
	
	require('./includes/session_dto.php');
	require('./includes/formSession.php');	

	require('../panel_admin/includes/film_dto.php');
	require('../panel_admin/includes/film_dao.php');
	
	$formSession = new FormSession();	
	$formHall = new FormHall();
	
	$placeholder_date = date("Y-m-d");
	$placeholder_hall = "1";
	$filtered = false;
	$cinema = "1";
	
	$formHall->processesForm(null, $cinema, null, null, "list");
		
	if(isset($_POST['filter']))	{
		$placeholder_date = $_POST["date"];
		$placeholder_hall = $_POST["hall"];
		$filtered = true;
		
		$formSession->processesForm(null, null, $placeholder_hall, $cinema, $placeholder_date, null, null, null, null, "list");
	}
													
	echo"				<form method=\"post\">	
					<!--Session Filter -->
					<div class = \"column middle\"> 
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
	function drawSessions($sessions){
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
		echo "
								<tr>
									<td> " . $s->getStartTime() . "</a></td>
									<td> " . $s->getIdfilm()  . "</a></td>
									<td> ". $s->getSeatPrice() . "</a></td>
									<td> <input type=\"submit\" name=\"submit\" value=\"Editar\" class=\"button\" formaction=\"./?state=edit_session&option=edit&id=". $s->getid() ."\"/> </td>
								</tr>"; 
		} 
		echo "
							<tbody>
						</table>
						<input type=\"submit\" name=\"submit\" value=\"Añadir\" class=\"button large\" formaction=\"./?state=edit_session&option=new\">
					</div>";	
		
	}
	if($formSession->getReply() != null){
		drawSessions($formSession->getReply());
	} else {
		echo "<div class=\"column side\">
				<p> No hay ninguna session en la sala ". $placeholder_hall . " el dia ". $placeholder_date . "</p>
		";
	}
	echo "	
					
				</form>";
?>	
				
