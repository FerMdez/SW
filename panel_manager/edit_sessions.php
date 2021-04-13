<?php
	require('./includes/hall_dto.php');
	require('./includes/session_dto.php');
	require('../panel_admin/includes/film_dto.php');
	include_once('./includes/session_dao.php');
	
	$r1 = new HallDTO(1,20,20,30);	//Esto se deberia cambiar por una llamada a una lista de salas
	$r2 = new HallDTO(2,10,30,30);
	$rooms = array($r1, $r2);	
	
	require_once('./includes/listFilms.php');
	$filmList = new Film_DAO('complucine');
	$films = $filmList->allFilmData();	

	//DISCLAIMER; sabemos que si se edita la ulr se pueden acceder a datos de una sesion que no pertenece al usuario y que incluso puede hasta editarlas/borrarlas en la base de datos
	if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'edit') {
		$bd = new sessionDAO('complucine');
		if($bd){
			$session = ($bd->sessionData($_GET["id"]))->fetch_assoc();
		echo "<h2>Editar/Eliminar Sesion</h2>
				<form method=\"post\" id=\"edit_ses\" action=\"validate.php\">
					<div class=\"row\">
						<fieldset id=\"datos\">
							<legend>Datos</legend>
							<input type=\"hidden\" name=\"cinema\" value =\"1\" />
							<input type=\"hidden\" name=\"id\" value =\"". $_GET["id"] ." \" />
							<div class=\"_price\">
								<input type=\"number\" name=\"price\" id=\"price\" value=\"". $session['seat_price'] ."\"min=\"0\" placeholder=\"Precio de la entrada\" required/>
							</div>
							<select name=\"hall\" class=\"button large\">";
							foreach($rooms as $r){ 
								if($r->getNumber() == $session['idhall']){
									echo "<option value=\"". $r->getNumber() ." \"selected> Sala ". $r->getNumber() . "</option>";
								}else{
									echo "<option value=\"". $r->getNumber() ." \"> Sala ". $r->getNumber() . "</option>";
									}
							}
							echo "<div class=\"_format\">
								<input type=\"text\" name=\"format\" id=\"format\" value=\"". $session['format'] ."\" placeholder=\"Formato\" required/>
							</div>
						</fieldset>
						<fieldset id=\"Horario\">
							<legend>Horario</legend>
							<div class=\"_start_time\">
								<input type=\"time\" name=\"start\" id=\"start_time\" value=\"". $session['start_time'] ."\" placeholder=\"Hora de inicio\" required/>
							</div>
							<div class=\"_date\">
								<input type=\"date\" name=\"date\" id=\"date\" value=\"". $session['date'] ."\"Fecha de inicio\" required/>
							</div>
							<div class=\"_repeat\">
								<br> Introducir un numero para añadir esta sesion a los futuros X dias 
								<input type=\"number\" name=\"repeat\" id=\"repeat\" title=\"Repetir esta sesion durante X dias\" min=\"0\" max=\"31\" placeholder=\"Repetir X dias\"/>
							</div>
						</fieldset>
						<div class=\"actions\"> 
							<input type=\"submit\" name=\"edit\" value=\"Editar\" class=\"primary\" />
							<input type=\"reset\" id=\"reset\" value=\"Limpiar\" />
							<input type=\"submit\" name=\"del\" value=\"Eliminar\" class=\"primary\" />							
						</div>
					</div>
				</form>
			<div>
			<div class=\"column side\">
				<select name=\"film\" form=\"edit_ses\" class=\"button large\">";
				foreach($films as $f){ 
					if($f->getId() == $session['idfilm']){
						echo "<option value=\"". $f->getId() ." \"selected> " . $f->getId() . "|" . $f->getTittle() ." Idioma: " . $f->getLanguage() . "</option>";
					}else{
						echo "<option value=\"". $f->getId() ." \"> " . $f->getId() . "|" . $f->getTittle() ." Idioma: " . $f->getLanguage() . "</option>";
					}
				}
			echo "</div>";
		}
	}
    else{
		echo "<h2>Crear Sesion</h2>
				<form method=\"post\" id=\"new_ses\" action=\"validateSession.php\">
					<div class=\"row\">
						<fieldset id=\"datos\">
							<legend>Datos</legend>
							<input type=\"hidden\" name=\"cinema\" value =\"1\" />
							<div class=\"_price\">
								<input type=\"number\" name=\"price\" id=\"price\" min=\"0\" placeholder=\"Precio de la entrada\" required/>
							</div>
							<select name=\"hall\" class=\"button large\">";
							foreach($rooms as $r){ 
								if($r->getid() == $_POST['hall']){
									echo "<option value=\"". $r->getid() ." \"selected> Sala ". $r->getid() . "</option>";
								}else{
									echo "<option value=\"". $r->getid() ." \"> Sala ". $r->getid() . "</option>";
									}
							}
							echo "<div class=\"_format\">
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
				<select name=\"film\" form=\"new_ses\" class=\"button large\">";
				foreach($films as $f){ 
					echo "<option value=\"". $f->getId() ." \"> " . $f->getId() . "|" . $f->getTittle() ." Idioma: " . $f->getLanguage() . "</option>";
				}
			echo "</div>";
	}

	?>

				
