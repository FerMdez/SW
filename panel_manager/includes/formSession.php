<?php
require_once($prefix.'assets/php/common/session_dao.php');
require_once($prefix.'assets/php/common/session.php');
require_once($prefix.'assets/php/form.php');

require_once($prefix.'panel_admin/includes/film.php');
require_once($prefix.'assets/php/common/film_dao.php');
	
//Receive data from froms and prepare the correct response
class FormSession extends Form {

    //Constructor:
    public function __construct() {
        parent::__construct('formSession');
    }
	
	public static function generaCampoFormulario($data, $errores = array()){
		
		$cinema = $data['cinema'] ?? '';
		$film = $data['film'] ?? '1';
		$hall = $data['hall'] ?? '1';
		$date = $data['date'] ?? '';
		$start = $data['start'] ?? '';
		$price = $data['price'] ?? '';
		$format = $data['format'] ?? '';
		
		$filmList = new Film_DAO('complucine');
		$films = $filmList->allFilmData();
		
		$htmlform .= '<div class="column left">
				<form method="post" id="'.$data['option'].'" action="./includes/processForm.php"\>
					<fieldset>
						<legend>Datos</legend>
						<input type="number" name="price" value="'.$number.'" min="0" placeholder="Precio de la entrada" required/> <br>
						<input type="text" name="format" value="'.$format.'" placeholder="Formato de pelicula" required/> <br>
						<select name="hall" class="button large">';
		foreach(Hall::getListHalls($cinema) as $hll){
				if($hll->getNumber() == $hall){
					$htmlform.= '
							<option value="'. $hll->getNumber() .'"selected> Sala '. $hll->getNumber() .'</option> ';
				}else{ 
					$htmlform.= '
							<option value="'. $hll->getNumber() .'"> Sala '. $hll->getNumber() .'</option>';
				}
			}
		$htmlform.= '
						</select>
					</fieldset>
					<fieldset>
						<legend>Horario</legend>
						<input type="time" name="start" value="'.$start.'" placeholder="Hora de inicio" required/> <br>
						<input type="date" name="date" value="'.$date.'" placeholder="Fecha de inicio" required/> <br>
					</fieldset>
						';		
		if($data['option'] == "new_session")
			$htmlform .= '<input type="number" name="repeat" value="" min="0" title="Añadir esta sesion durante los proximos X dias" min="0" max="31" placeholder="Añadir X dias"/> <br>
			<button type="submit" name="new_session" class="button large">Crear</button><br>';
		if($data['option'] == "edit_session")
			$htmlform .= '<button type="submit" name="edit_session" class="button large">Editar</button><br>
			<button type="submit" name="delete_session" class="primary">Borrar</button><br>';
		$htmlform .= '
		<input type="reset" value="Limpiar Campos" >
				</form>
				</div>
				<div class="column right">
					<select name="film" form="'.$data['option'].'" class="button large">';
		foreach($films as $f){
			if($f->getId() == $film){
					$htmlform.= '
						<option value="'. $f->getId() .'" selected> '.$f->getId().' | '.str_replace('_', ' ',$f->getTittle()).' Idioma: '.$f->getLanguage().' </option>';
			}else {	
					$htmlform.= '
						<option value="'. $f->getId() .'"> '.$f->getId().' | '.str_replace('_', ' ',$f->getTittle()).' Idioma: '.$f->getLanguage().' </option>';
			}
		}
		$htmlform .= '
					</select>
				</div>
';
		return $htmlform;	
	}
    //Methods:

    //Process form:
    public static function processesForm($data){
		if($data["option"] == "new_session"){
			$_SESSION['msg'] = Session::create_session($data);
			header( "Location: ../?state=success" );
		}else {
			
		}			
    }
}

?>

