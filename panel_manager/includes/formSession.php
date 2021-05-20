<?php
require_once($prefix.'assets/php/common/session_dao.php');
require_once($prefix.'assets/php/common/session.php');
require_once($prefix.'assets/php/form.php');

//Receive data from froms and prepare the correct response
class FormSession extends Form {

	private $option;
	private $cinema;
	private $formID;
	 
    //Constructor:
    public function __construct($option, $cinema) {
		$this->option = $option;
		$this->cinema = $cinema;
		$this->formID = 'formSession1';
		
		$options = array("action" => "./?state=".$option);
        parent::__construct('formSession',$options);
    }
	
	//TODO Edit session no funciona correctamente con el seleccionar una pelicula distinta, hay que guardar la id de la sesion de alguna forma y usarla o guardar en la sesion
	protected function generaCamposFormulario($data, $errores = array()){
		
		$hall = $data['hall'] ?? $_POST["hall"] ?? "";
		$date = $data['date'] ?? $_POST["date"] ?? "";
		$start = $data['start'] ?? $_POST["start"] ?? "";
		$price = $data['price'] ?? $_POST["price"] ?? "";
		$format = $data['format'] ?? $_POST["format"] ?? "";
		
		$or_hall = $data["or_hall"] ?? $hall;
		$or_date = $data["or_date"] ?? $date;
		$or_start = $data["or_start"] ?? $start;
			
		$film = $data['film'] ?? $_POST["film"] ?? "";
		$tittle = $data['tittle'] ?? $_POST["tittle"] ?? "";
		$duration = $data['duration'] ?? $_POST["duration"] ?? "";
		$language = $data['language'] ?? $_POST["language"] ?? "";
		$description = $data['description'] ?? $_POST["description"] ?? "";
		
		$htmlErroresGlobales = self::generaListaErroresGlobales($errores);
		$errorPrice = self::createMensajeError($errores, 'price', 'span', array('class' => 'error'));
		$errorFormat = self::createMensajeError($errores, 'format', 'span', array('class' => 'error'));
		$errorDate = self::createMensajeError($errores, 'date', 'span', array('class' => 'error'));
		$errorStart = self::createMensajeError($errores, 'start', 'span', array('class' => 'error'));
		
		$html = '
				<div class="column left">'.$htmlErroresGlobales.' 
					<fieldset>
						<legend>Datos</legend>
						'.$errorPrice.'
						<input type="number" step="0.01" name="price" value="'.$price.'" min="0" placeholder="Precio de la entrada" /> <br>'
						.$errorFormat.'
						<input type="text" name="format" value="'.$format.'" placeholder="Formato de pelicula" /> <br>
						<input type="hidden" name="film" value="'.$film.'"/> 
						<input type="hidden" name="option" value="'.$this->option.'"/> 
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
						'.$errorStart.'
						<input type="time" name="start" value="'.$start.'" placeholder="Hora de inicio"/> <br>
						<input type="hidden" name="or_start" value="'.$or_start.'"/>
						'.$errorDate.'
						<input type="date" name="date" value="'.$date.'" placeholder="Fecha de inicio" /> <br>
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
		$html .= "
		<input type='reset' id='reset' value='Limpiar Campos' >
				</form>
				</div>
				<div class='column side'>";
				if($film){
					$html .= "<section id='".$tittle."'>
                                <div class='code showtimes'>
                                    <div class='image'><img src='../img/films/".$tittle.".jpg' alt='".$tittle."' /></div>
                                    <h2>".str_replace('_', ' ',$tittle)."</h2>
                                    <hr />
                                    <div class='blockquote'>
                                        <p>".$description."</p>
                                    </div>
                                    <li>Duración: ".$duration." minutos</li>
									<li>Duración: ".$language." minutos</li>
                                </div>
                        </section>
					";
				}
				$html .= '<input type="submit" name="select_film" form="'.$this->formID.'" formaction="?state=select_film" class="button large" Value="Seleccionar una Pelicula" /><br>
				</div>
';
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

		if (($price <= 0 || empty($price))&& isset($data["sumbit"]) ) {
            $result['price'] = "<li> No puede haber 0 o menos euros. </li> <br>";
		}
		
		if ((empty($format))&& isset($data["sumbit"]) ) {
            $result['format'] = "<li> El formato no puede estar vacio. </li> <br>";
		}
		
		if ((empty($date))&& isset($data["sumbit"]) ) {
            $result['date'] = "<li> No hay una fecha seleccionada. </li> <br>";
		}
		
		if ((empty($start))&& isset($data["sumbit"]) ) {
            $result['start'] = "<li> No hay una hora inicial seleccionada. </li> <br>";
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