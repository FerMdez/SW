<?php

require_once($prefix.'assets/php/includes/film_dao.php');

class NewSessionForm {

	public static function getForm(){
		$films = new Film_DAO("complucine");
        $filmslist = $films->allFilmData();
		
		$form='
		<div id="operation_msg" class="operation_msg"> </div>
		<form id="new_session_form" name="new_session_form" action="eventos.php.php" method="POST">
			<div id="global_group" class="form_group"></div>
			<fieldset>
				<legend>Datos</legend>
				 <div id="price_group" class="form_group">
					<input type="number" step="0.01" id="price" name="price" value="" min="0" placeholder="Precio de la entrada" /> <br>
				</div>
				<div id="format_group" class="form_group">
					<input type="text" id="format" name="format" value="" placeholder="Formato de pelicula" /> <br>
				</div>
				<div id="hall_group" class="form_group">
					<select id="hall" name="hall" class="button large">>';
				foreach(Hall::getListHalls($_SESSION["cinema"]) as $hll){
						$form.= '
									<option value="'. $hll->getNumber() .'"> Sala '. $hll->getNumber() .'</option>';
				}
		$form.='	</select>
				</div>
			</fieldset>
			<fieldset>
				<legend>Horario</legend>
				<div id="date_group" class="form_group">
					<div class="two-inputs-line">
						<label> Fecha inicio </label>
						<label> Fecha final </label>
						<input type="date" id="startDate" name="startDate" value=""/>
						<input type="date" id="endDate" name="endDate" value=""/>
					</div>
				</div>
				<div id="hour_group" class="form_group">
					<div class="one-input-line">
						<label> Hora sesion </label>
						<input type="time" id="startHour" name="startHour" value=""/>
					</div>
				</div>
			</fieldset>
			<input type="reset" id="reset" value="Limpiar Campos" >
			<input type="submit" id="submit" name="sumbit" class="primary" value="Crear" />
		<div id="film_msg_group" class="form_group"> </div>
		<div id="film_group" class="form_group">
			<div class="code showtimes">
				<input type="hidden" id="film_id" name="film_id" value=""/>
				<h2 id="film_title"> titulo </h2>
				<hr />
				<div class="img_desc">
					<div class="image"> <img src="../img/films/iron_man.jpg" alt="iron man" id="film_img" /> </div>
					<div class="blockquote">
						<p id="film_desc">"Un empresario millonario construye un traje blindado y lo usa para combatir el crimen y el terrorismo."</p>
					</div>
				</div>
				<li id="film_dur"> Duración: duracion minutos</li>
				<li id="film_lan"> Lenguaje: idioma </li>
				</div>
			<button type="button" class="button large" id="return"> Cambiar pelicula </button>
		</div>
		<div class="film_list" id="film_list">
			<ul class="tablelist col3">'; 
		$parity = "odd";
		$i = 0;
		foreach($filmslist as $film){ 
			$form .='<div class="'.$parity.'">
						<input type="hidden" value="'.$film->getId().'" id="id'.$i.'"/>
						<input type="hidden" value="'.$film->getImg().'" id="img'.$i.'"/>
						<input type="hidden" value="'.$film->getLanguage().'" id="lan'.$i.'"/>
						<input type="hidden" value="'.$film->getDescription().'" id="desc'.$i.'"/>
						<li value="'.$film->getTittle().'"id="title'.$i.'"> '. str_replace('_', ' ',$film->getTittle()).'</li>
						<li id="dur'.$i.'"> '.$film->getDuration().' min</li>
						<li> <button type="button" class="film_button" id="'.$i.'"> Seleccionar </button> </li>
					</div>
					';
			$parity = ($parity == "odd") ? "even" : "odd";
			$i++;
			}
		$form.='
			</ul>
		</div>
		</form>';

		return $form;
	}

}
?>