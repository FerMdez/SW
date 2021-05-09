<?php
require_once($prefix.'assets/php/common/session_dao.php');
require_once($prefix.'assets/php/common/session.php');
require_once($prefix.'assets/php/form.php');
	
//Receive data from froms and prepare the correct response
class FormSession extends Form {

    //Constructor:
    public function __construct() {
        parent::__construct('formSession');
    }
	
	//TODO Edit session no funciona correctamente con el seleccionar una pelicula distinta, hay que guardar la id de la sesion de alguna forma y usarla o guardar en la sesion
	public static function generaCampoFormulario($data, $errores = array()){
		
		$cinema = $data['cinema'] ?? '';
		$film = $data['film'] ?? '';
		$hall = $data['hall'] ?? '';
		$date = $data['date'] ?? '';
		$start = $data['start'] ?? '';
		$price = $data['price'] ?? '';
		$format = $data['format'] ?? '';
		
		$htmlform .= '<div class="column left">
				<form method="post" id="'.$data['option'].'" action="./includes/processForm.php"\>
					<fieldset>
						<legend>Datos</legend>
						<input type="number" step="0.01" name="price" value="'.$price.'" min="0" placeholder="Precio de la entrada" required/> <br>
						<input type="text" name="format" value="'.$format.'" placeholder="Formato de pelicula" required/> <br>
						<input type="hidden" name="film" value="'.$film["idfilm"].'"/> 
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
		if($film){
			if($data['option'] == "new_session")
				$htmlform .= '<input type="number" name="repeat" value="" min="0" title="Añadir esta sesion durante los proximos X dias" min="0" max="31" placeholder="Añadir X dias"/> <br>
				<button type="submit" name="new_session" class="button large">Crear</button><br>';
				
			if($data['option'] == "edit_session"){
				if(!$_SESSION["or_hall"]) $_SESSION["or_hall"] = $hall;
				if(!$_SESSION["or_date"]) $_SESSION["or_date"] = $date;
				if(!$_SESSION["or_start"])$_SESSION["or_start"] = $start;
				
				$htmlform .= '
				<button type="submit" name="edit_session" class="button large">Editar</button><br>
				<button type="submit" name="delete_session" class="primary">Borrar</button><br>';
			}
		}
		$htmlform .= "
		<input type='reset' value='Limpiar Campos' >
				</form>
				</div>
				<div class='column side'>";
				if($film["tittle"]){
					$htmlform .= " <section id='".$film["tittle"]."'>
                                <div class='code showtimes'>
                                    <div class='image'><img src='../img/".$film["tittle"].".jpg' alt='".$film["tittle"]."' /></div>
                                    <h2>".str_replace('_', ' ',$film["tittle"])."</h2>
                                    <hr />
                                    <div class='blockquote'>
                                        <p>".$film["description"]."</p>
                                    </div>
                                    <p>Duración: ".$film["duration"]." minutos</p>
                                </div>
                        </section>
";
				}
				$htmlform .= '<button type="submit" name="select_films" form="'.$data['option'].'" formaction="?state=select_film&option='.$data['option'].'" class="button large">Seleccionar una Pelicula</button><br>
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
		}else if($data["option"] == "edit_session"){
			$_SESSION['msg'] = Session::edit_session($data);
			header( "Location: ../?state=success" );
		}
		else if($data["option"] == "delete_session") {
			$_SESSION['msg'] = Session::delete_session($data);
			header( "Location: ../?state=success" );
		}			
    }
}

?>