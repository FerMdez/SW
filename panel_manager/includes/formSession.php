<?php
require_once($prefix.'assets/php/common/session_dao.php');
require_once($prefix.'assets/php/common/film_dao.php');
require_once($prefix.'assets/php/common/session.php');
require_once($prefix.'assets/php/form.php');

//Receive data from froms and prepare the correct response
class FormSession extends Form {

	private $option;
	private $cinema;
	
    //Constructor:
    public function __construct($option, $cinema) {
		$this->option = $option;
		$this->cinema = $cinema;
		$options = array("action" => "./?state=".$option);
        parent::__construct('formSession',$options);
    }
	
	//TODO Edit session no funciona correctamente con el seleccionar una pelicula distinta, hay que guardar la id de la sesion de alguna forma y usarla o guardar en la sesion
	protected function generaCamposFormulario($data, $errores = array()){

		$filmList = new Film_DAO('complucine');
		$films = $filmList->allFilmData();	
		
		if($this->option == "new_session") {
			$film = $data['film'] ?? 1;
			$hall = $data['hall'] ?? $_POST["hall"];
			$date = $data['date'] ?? $_POST["date"];
			$start = $data['start'] ?? '';
			$price = $data['price'] ?? '';
			$format = $data['format'] ?? '';
		} 
		else {
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
		$errorFormat = self::createMensajeError($errores, 'format', 'span', array('class' => 'error'));
		
		$html = '
				<div class="column left">'.$htmlErroresGlobales.' '.$errorPrice.'
					<fieldset>
						<legend>Datos</legend>
						<input type="number" step="0.01" name="price" value="'.$price.'" min="0" placeholder="Precio de la entrada" required/> <br>'.$errorFormat.'
						<input type="text" name="format" value="'.$format.'" placeholder="Formato de pelicula" required/> <br>
						<input type="hidden" name="film" value="'.$film.'"/> 
						<select name="hall" class="button large">';
			foreach(Hall::getListHalls($this->cinema) as $hll){
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
					<input type="submit" id="submit" name="sumbit" class="primary" value="Crear" /> <br>';
				
			if($this->option == "edit_session"){			
				$html .= '<input type="submit" id="submit" name="sumbit" class="primary" value="Editar" /><br>
					<input type="submit" name="delete" class="black button" onclick="return confirm(\'Seguro que quieres borrar esta sesion?\')"  value="Borrar" /><br>';
			}
		}
		$html .= '
					<input type="reset" id="reset" value="Limpiar Campos" />
				</div>
				<div class="column rigth">
					<select name="film" class="button large">
						';
				foreach($films as $f){ 
					if($f->getId() == $film){
						$html .=  "<option value=\"". $f->getId() ." \"selected> " . $f->getId() . "|" . $f->getTittle() ." Idioma: " . $f->getLanguage() . "</option>
						";
					}else{
						$html .=  "<option value=\"". $f->getId() ." \"> " . $f->getId() . "|" . $f->getTittle() ." Idioma: " . $f->getLanguage() . "</option>
						";
					}
				}
		$html .= '</select>';
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
                $_SESSION['msg'] = Session::create_session($this->cinema, $hall, $start, $date, $film, $price, $format,$repeat);
                $result = './?state=success';
            }
			if($this->option == "edit_session"){
                $_SESSION['msg'] = Session::edit_session($this->cinema, $or_hall, $or_date, $or_start, $hall, $start, $date, $film, $price, $format);
                $result = './?state=success';
            }
        }

		if(!isset($result['hall']) && !isset($result['start']) && !isset($result['date']) && isset($data["delete"])) {
			$_SESSION['msg'] = Session::delete_session($this->cinema, $or_hall, $or_start, $or_date);
			$result = './?state=success';
		}
 
        return $result;		
    }
}

?>