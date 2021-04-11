<?php
	require('./includes/room_dto.php');
	require('./includes/session_dto.php');
	require('../panel_admin/includes/film_dto.php');
	
	$r1 = new RoomDTO(1,20,20,30);	//Esto se deberia cambiar por una llamada a una lista de salas
	$r2 = new RoomDTO(2,10,30,30);
	$rooms = array($r1, $r2);	
	
	require_once('./includes/listFilms.php');
	$filmList = new ListFilms();
	$films = $filmList->getArray();	

		
	if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'edit') {
		echo "<p> Este es el panel de editar o eliminar una sesion. Deberia tener el formulario de crear una sesion nueva pero con los datos ya situados y quizas que solo aqui aparezca el boton de eliminar </p>";
    }
    else{
		echo "<h2>Crear Sesion</h2>
				<form method=\"post\" id=\"new_ses\" action=\"validate.php\">
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
						</fieldset>
						<div class=\"actions\"> 
							<input type=\"submit\" id=\"submit\" value=\"Añadir\" class=\"primary\" />
							<input type=\"reset\" id=\"reset\" value=\"Borrar\" />       
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

				
