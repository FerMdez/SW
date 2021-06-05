<?php

require_once($prefix.'assets/php/includes/film_dao.php');

class NewSessionForm {

	public static function getForm(){
		$films = new Film_DAO("complucine");
        $filmslist = $films->allFilmData();
		
		$form='
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
				<div id="hall_group" class="form_group">';
				foreach(Hall::getListHalls($_SESSION["cinema"]) as $hll){
					if($hll->getNumber() == $hall){
						$panel.= '
									<option data-feed="./eventos.php?hall='.$hll->getNumber().'" value="'. $hll->getNumber() .'"selected> Sala '. $hll->getNumber() .'</option> ';
					}else{ 
						$panel.= '
									<option data-feed="./eventos.php?hall='.$hll->getNumber().'" value="'. $hll->getNumber() .'"> Sala '. $hll->getNumber() .'</option>';
					}
				}
		$form.='</select>
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
		</form>
		<div id="film_group" class="form_group">
		
		
		
		</div>
		<div class="film_list">
			<ul class="tablelist col3">'; 
		$parity = "odd";
		foreach($filmslist as $film){ 
			$form .='<div class="'.$parity.'">
						<li> '. str_replace('_', ' ',$film->getTittle()).'</li>
						<li> '.$film->getDuration().' min</li>
						<li> <button type="button" id="select_button"> Seleccionar </button> </li>
					</div>
					';
			$parity = ($parity == "odd") ? "even" : "odd";
			}
		$form.='
			</ul>
		</div>';

		return $form;
	}

}
?>