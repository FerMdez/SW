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
		$rows = $data['rows'] ?? '14';
		$cols = $data['cols'] ?? '8';
		$seats = $data['seats'] ?? '';
		
		$htmlform .= '<div class="column left">
					<form method="post" id="seat_filter" action="./?state='.$data['option'].'"\>
						<fieldset>
							<legend> Configuracion </legend>
							<input type="number" name="rows" value="'.$rows.'" min="1" placeholder="Numero de filas" required/> <br>
							<input type="number" name="cols" value="'.$cols.'" min="1" placeholder="Numero de cols" required/> <br>
							<button type="submit" name="seat_filter" class="button large">Actualizar</button><br>
						</fieldset>
					</form>
					<br>
					<br>
					<form method="post" id="'.$data['option'].'" action="./includes/processForm.php"\>
						<fieldset>
							<input type="number" name="number" value="'.$number.'" min="1" placeholder="Numero de la sala" required/> <br>
							<input type="hidden" name="rows" value="'.$rows.'" min="1"/>
							<input type="hidden" name="cols" value="'.$cols.'" min="1"/>
							';
		if($data['option'] == "new_hall")
			$htmlform .= '<button type="submit" name="new_hall" class="button large">Crear</button><br>';
		
		$htmlform .= '
						</fieldset>
					
				</div>
				<div class="column right">
					<h3 class="table_title"> Pantalla </h3>
					<table class="seat">
					<thead>
						<tr>
							<th></th>';
			for($j = 1; $j<=$cols; $j++){
				$htmlform .= '<th>'.$j.'</th>';	
			}
				$htmlform .= '</tr>
					</thead>
					<tbody>';
				for($i = 1;$i<=$rows;$i++){
						$htmlform .= '
						<tr>
						<td>'.$i.'</td>
						';
					for($j=1; $j<=$cols; $j++){
						$htmlform .= '<td> <input type="checkbox" class="check_box" name="checkbox'.$i.$j.'" id="checkbox'.$i.$j.'" value="1" checked> <label for="checkbox'.$i.$j.'"> </td>'
						;
					}
						$htmlform .='
						</tr>';
				}
					
		$htmlform .= '
					</tbody>
					</table>
				</form>
				</div>
				';		
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

