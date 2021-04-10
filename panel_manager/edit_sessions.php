<?php
	require('./includes/room_dto.php');
	require('./includes/session_dto.php');
	
	if(isset($_REQUEST['option']) && $_REQUEST['option'] == 'edit') {
		echo "<p> Este es el panel de editar o eliminar una sesion. Deberia tener el formulario de crear una sesion nueva pero con los datos ya situados y quizas que solo aqui aparezca el boton de eliminar </p>";
    }
    else{
		echo "<h2>Crear Sesion</h2>
				<form method=\"post\" action=\"validate.php\">
					<div class=\"row\">
						<fieldset id=\"datos\">
							<legend>Datos</legend>
							<div class=\"_price\">
								<input type=\"number\" name=\"price\" id=\"price\" min=\"0\" placeholder=\"Precio de la entrada\" required/>
							</div>
							<div class=\"_film\">
								<input type=\"text\" name=\"film\" id=\"film\" value=\"\" placeholder=\"ID de la pelicula\" required/>
							</div>
							<div class=\"_format\">
								<input type=\"text\" name=\"format\" id=\"format\" value=\"\" placeholder=\"Formato\" required/>
							</div>
						</fieldset>
						<fieldset id=\"Horario\">
							<legend>Horario</legend>
							<div class=\"_start_time\">
								<input type=\"time\" name=\"start\" id=\"start_time\" value=\"\" placeholder=\"Hora de inicio\" required/>
							</div>
						</fieldset>
						<div class=\"actions\"> 
							<input type=\"submit\" id=\"submit\" value=\"Añadir\" class=\"primary\" />
							<input type=\"reset\" id=\"reset\" value=\"Borrar\" />       
						</div>
					</div>
				</form>";
	}
	echo "</div>"
	?>

				
