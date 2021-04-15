<?php
	//General Config File:
    require_once('../assets/php/config.php');

	include_once('./includes/formHall.php');	
	require_once('./includes/hall_dto.php');
	
	require_once('./includes/session_dto.php');
	include_once('./includes/session_dao.php');
	
	require_once('../panel_admin/includes/film_dto.php');
	include_once('../panel_admin/includes/film_dao.php');
	
	$formHall = new FormHall();
	$formHall->processesForm(null, $_SESSION["cinema"], null, null, "list");
	

	
	$filmList = new Film_DAO('complucine');
	
	if($filmList){
		$films = $filmList->allFilmData();	
	}else {
		$films = null;
	}

	if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'edit') { 
		$_SESSION["hall"] =	$_POST['hall'];
		$_SESSION["date"] = $_POST['date'];
		$_SESSION["start"] = $_POST['start'];
	
		echo "				<div class = \"column middle\">
					<h2>Editar/Eliminar Sesion</h2>
					<form method=\"post\" id=\"edit_ses\" action=\"validateSession.php\">
						<div class=\"row\">
							<fieldset id=\"datos\">
								<legend>Datos</legend>
								<div class=\"_price\">
									<input type=\"number\" name=\"price\" step=\"0.01\"id=\"price\" value=\"". $_POST['price'] ."\"min=\"0\" placeholder=\"Precio de la entrada\" required/>
								</div>
								<select name=\"hall\" class=\"button large\">";
								foreach($formHall->getReply() as $r){ 
									if($r->getNumber() == $_POST['hall']){
										echo "<option value=\"". $r->getNumber() ." \"selected> Sala ". $r->getNumber() . "</option>";
									}else{
										echo "<option value=\"". $r->getNumber() ." \"> Sala ". $r->getNumber() . "</option>";
										}
								}
								echo "
									<div class=\"_format\">
									<input type=\"text\" name=\"format\" id=\"format\" value=\"". $_POST['format'] ."\" placeholder=\"Formato\" required/>
								</div>
							</fieldset>
							<fieldset id=\"Horario\">
								<legend>Horario</legend>
								<div class=\"_start_time\">
									<input type=\"time\" name=\"start\" id=\"start_time\" value=\"". $_POST['start'] ."\" placeholder=\"Hora de inicio\" required/>
								</div>
								<div class=\"_date\">
									<input type=\"date\" name=\"date\" id=\"date\" value=\"". $_POST['date'] ."\"Fecha de inicio\" required/>
								</div>
							</fieldset>
							<div class=\"actions\"> 
								<input type=\"submit\" name=\"edit\" value=\"Editar\" class=\"button\"  />
								<input type=\"reset\" id=\"reset\" value=\"Limpiar\" />
								<input type=\"submit\" name=\"del\" value=\"Eliminar\" class=\"button\"  />							
							</div>
						</div>
					</form>
				<div>
				<div class=\"column side\">
					<select name=\"film\" form=\"edit_ses\" class=\"button large\">\n";
				foreach($films as $f){ 
					if($f->getId() == $_POST['idfilm']){
							echo "						<option value=\"". $f->getId() ." \"selected> " . $f->getId() . "|" . $f->getTittle() ." Idioma: " . $f->getLanguage() . "</option>\n";
					}else{
							echo "						<option value=\"". $f->getId() ." \"> " . $f->getId() . "|" . $f->getTittle() ." Idioma: " . $f->getLanguage() . "</option>\n";
					}
				}
				echo "				</div>";
	}
	
    else{
		echo "				<div class = \"column middle\">
					<h2>Crear Sesion</h2>
					<form method=\"post\" id=\"new_ses\" action=\"validateSession.php\">
						<div class=\"row\">
							<fieldset id=\"datos\">
								<legend>Datos</legend>
								<input type=\"hidden\" name=\"cinema\" value =\"1\" />
								<div class=\"_price\">
									<input type=\"number\" name=\"price\" step=\"0.01\" id=\"price\" min=\"0\" placeholder=\"Precio de la entrada\" required/>
								</div>
								<select name=\"hall\" class=\"button large\">";
								foreach($formHall->getReply() as $r){ 
										if($r->getNumber() == $_POST['hall']){
											echo "
									<option value=\"". $r->getNumber() ." \"selected> Sala ". $r->getNumber() . "</option>";
										}else{
											echo "
									<option value=\"". $r->getNumber() ." \"> Sala ". $r->getNumber() . "</option>";
										}
									}
								echo "
								<div class=\"_format\">
									<input type=\"text\" name=\"format\" id=\"format\" value=\"\" placeholder=\"Formato\" required/>
								</div>
							</fieldset>
							<fieldset id=\"Horario\">
								<legend>Horario</legend>
								<div class=\"_start_time\">
									<input type=\"time\" name=\"start\" id=\"start_time\" value=\"\" placeholder=\"Hora de inicio\" required/>
								</div>
								<div class=\"_date\">
									<input type=\"date\" name=\"date\" id=\"date\" value=\"". $_POST['date'] . "\"Fecha de inicio\" required/>
								</div>
								<div class=\"_repeat\">
									<br> Introducir un numero para añadir esta sesion a los futuros X dias 
									<input type=\"number\" name=\"repeat\" id=\"repeat\" title=\"Repetir esta sesion durante X dias\" min=\"0\" max=\"31\" placeholder=\"Repetir X dias\"/>
								</div>
							</fieldset>
							<div class=\"actions\"> 
								<input type=\"submit\" name=\"new\" value=\"Añadir\" class=\"primary\" />
								<input type=\"reset\" id=\"reset\" value=\"Limpiar\" />       
							</div>
						</div>
					</form>
				<div>
				<div class=\"column side\">
					<select name=\"film\" form=\"new_ses\" class=\"button large\">\n";
				foreach($films as $f){ 
					echo "						<option value=\"". $f->getId() ." \"> " . $f->getId() . "|" . $f->getTittle() ." Idioma: " . $f->getLanguage() . "</option>\n";
				}
			echo "				</div>";
	}

	?>

				
