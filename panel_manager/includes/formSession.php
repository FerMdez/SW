<?php
require_once($prefix.'assets/php/common/session_dao.php');
require_once($prefix.'assets/php/common/film_dao.php');
require_once($prefix.'assets/php/common/session.php');
require_once($prefix.'assets/php/form.php');

//Receive data from froms and prepare the correct response
class FormSession extends Form {

	private $option;

    //Constructor:
    public function __construct($option) {
		$this->option = $option;
		$options = array("action" => "./?state=".$option);
        parent::__construct('formSession',$options);
    }
	
	//TODO Edit session no funciona correctamente con el seleccionar una pelicula distinta, hay que guardar la id de la sesion de alguna forma y usarla o guardar en la sesion
	protected function generaCamposFormulario($data, $errores = array()){

		$filmList = new Film_DAO('complucine');
		$films = $filmList->allFilmData();	
		
		if($this->option == "new_session") {
			$cinema = $data['cinema'] ?? $_SESSION["cinema"];
			$film = $data['film'] ?? 1;
			$hall = $data['hall'] ?? '';
			$date = $data['date'] ?? '';
			$start = $data['start'] ?? '';
			$price = $data['price'] ?? '';
			$format = $data['format'] ?? '';
		} 
		else {
			$cinema = $data['cinema'] ?? $_SESSION["cinema"];
			$film = $data['film'] ?? $_POST["film"];
			$hall = $data['hall'] ?? $_POST["hall"];
			$date = $data['date'] ?? $_POST["date"];
			$start = $data['start'] ?? $_POST["start"];
			$price = $data['price'] ?? $_POST["price"];
			$format = $data['format'] ?? $_POST["format"];
		}
		$or_hall = $data["or_hall"] ?? $hall;
		$or_date = $data["or_date"] ?? $date;
		$or_start = $data["or_start"] ?? $start;

		$htmlErroresGlobales = self::generaListaErroresGlobales($errores);
		$errorPrice = self::createMensajeError($errores, 'price', 'span', array('class' => 'error'));

		$html .= '<div class="column left">
				 '.$htmlErroresGlobales.'
				 '.$errorPrice.'
					<fieldset>
						<legend>Datos</legend>
						<input type="number" step="0.01" name="price" value="'.$price.'" min="0" placeholder="Precio de la entrada" required/> <br>
						'.$errorFormat.'
						<input type="text" name="format" value="'.$format.'" placeholder="Formato de pelicula" required/> <br>
						<input type="hidden" name="film" value="'.$film.'"/> 
						<select name="hall" class="button large">';
			foreach(Hall::getListHalls($cinema) as $hll){
				if($hll->getNumber() == $hall){
					$html.= '
							<option value="'. $hll->getNumber() .'"selected> Sala '. $hll->getNumber() .'</option> ';
				}else{ 
					$html.= '
							<option value="'. $hll->getNumber() .'"> Sala '. $hll->getNumber() .'</option>';
				}
			}
		$html.= '
						</select>
						<input type="hidden" name="or_hall" value="'.$or_hall.'"/>
					</fieldset>
					<fieldset>
						<legend>Horario</legend>
						<input type="time" name="start" value="'.$start.'" placeholder="Hora de inicio" required/> <br>
						<input type="hidden" name="or_start" value="'.$or_start.'"/>
						<input type="date" name="date" value="'.$date.'" placeholder="Fecha de inicio" required/> <br>
						<input type="hidden" name="or_date" value="'.$or_date.'"/>
					</fieldset>
						';		
		if($film){
			if($this->option == "new_session")
				$html .= '<input type="number" name="repeat" value="" min="0" title="Añadir esta sesion durante los proximos X dias" min="0" max="31" placeholder="Añadir X dias"/> <br>
				<button type="submit" id="submit" name="sumbit" class="button large">Crear</button><br>';
				
			if($this->option == "edit_session"){			
				$html .= '
				<button type="submit" id="submit" name="sumbit" class="button large">Editar</button><br>
				<button type="submit" id="submit" name="delete" class="primary">Borrar</button><br>';
			}
		}
		$html .= '
		<input type="reset" value="Limpiar Campos" >
				</div>
				<div class="column side">
				<select name="film" class="button large">';
				foreach($films as $f){ 
					if($f->getId() == $film){
						$html .=  "<option value=\"". $f->getId() ." \"selected> " . $f->getId() . "|" . $f->getTittle() ." Idioma: " . $f->getLanguage() . "</option>";
					}else{
						$html .=  "<option value=\"". $f->getId() ." \"> " . $f->getId() . "|" . $f->getTittle() ." Idioma: " . $f->getLanguage() . "</option>";
					}
				}
				
		return $html;	
	}
    //Methods:

    //Process form:
	protected function procesaFormulario($data){
		$result = array();

		$film = $data['film'] ;
		$hall = $data['hall'] ;
		$date = $data['date'] ;
		$start = $data['start'];
		$price = $data['price'] ;
		$format = $data['format'] ;
		$repeat = $data['repeat'] ?? 0;
		$or_hall = $data["or_hall"] ;
		$or_date = $data["or_date"] ;
		$or_start = $data["or_start"] ;

		if (($price == 0 || empty($price))&& isset($data["sumbit"]) ) {
            $result['price'] = "<li> No puede haber 0 euros. </li> <br>";
		}
	
		
        if (count($result) === 0 && isset($data["sumbit"]) ) {
			if($this->option == "new_session"){
                $_SESSION['msg'] = Session::create_session($_SESSION["cinema"], $hall, $start, $date, $film, $price, $format,$repeat);
                $result = './?state=success';
            }
			if($this->option == "edit_session"){
                $_SESSION['msg'] = Session::edit_session($_SESSION["cinema"], $or_hall, $or_date, $or_start, $hall, $start, $date, $film, $price, $format);
                $result = './?state=success';
            }
        }

		if(!isset($result['hall']) && !isset($result['start']) && !isset($result['date']) && isset($data["delete"])) {
			$_SESSION['msg'] = Session::delete_session($_SESSION["cinema"], $or_hall, $or_start, $or_date);
			$result = './?state=success';
		}
 
        return $result;		
    }
}

?>