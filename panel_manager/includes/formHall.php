<?php
include_once($prefix.'assets/php/common/hall_dao.php');
include_once($prefix.'assets/php/form.php');

class FormHall extends Form {

    //Constructor:
    public function __construct() {
        parent::__construct('formHall');
    }
	
	public static function generaCampoFormulario($data, $errores = array()){

		$number = $data['number'] ?? '';
		$rows = $data['rows'] ?? '';
		$cols = $data['cols'] ?? '';
		$seats = $data['seats'] ?? '';
		
		$htmlform .= '<form method="post" id="'.$data['option'].'" action="./includes/processForm.php"\>
						<fieldset>
							<input type="number" name="number" value="'.$number.'" min="1" placeholder="Numero de la sala" required/> <br>
							<input type="number" name="rows" value= "'.$rows.'" min="1" placeholder="Filas" required/><br>
							<input type="number" name="cols" value= "'.$cols.'" min="1" placeholder="Columnas" required/><br>
							<input type="number" name="seats" value= "'.$seats.'" min="1" placeholder="Total de butacas?" /><br>
							';
		if($data['option'] == "new_hall")
			$htmlform .= '<button type="submit" name="new_hall" class="button large">Crear</button></div><br>';
		
		$htmlform .= '
						</fieldset>
					</form>';		
		return $htmlform;	
	}
    //Methods:

    //Process form:
    public static function processesForm($data){
		if($data["option"] == "new_hall"){
			$_SESSION['msg'] = Hall::create_hall($data);
			header( "Location: ../?state=success" );
		}else {
			
		}			
    }
}

?>

