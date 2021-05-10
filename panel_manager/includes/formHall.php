<?php
include_once($prefix.'assets/php/common/hall.php');
include_once($prefix.'assets/php/common/seat.php');
include_once($prefix.'assets/php/form.php');
	
class FormHall extends Form {
	
	private $option;
	
    //Constructor:
    public function __construct($option) {
		$this->option = $option;
		$options = array("action" => "./?state=".$option);
        parent::__construct('formHall',$options);
    }
	
	protected function generaCamposFormulario($data, $errores = array()){
		//Prepare the data
		if($this->option == "new_hall"){
			$number = $data['number'] ?? "";
			$rows = $data['rows'] ?? '12';
			$cols = $data['cols'] ?? '8';
		}else {
			$number = $data['number'] ?? $_POST["number"];
			$rows = $data['rows'] ?? $_POST["rows"];
			$cols = $data['cols'] ?? $_POST["cols"];
		}
		$og_number = $data['og_number'] ?? $number;
		
		//Seats_map
		$seats = 0;
		$seats_map = array();

		//Show the original seats_map once u click restart or the first time u enter this form from manage_halls's form
		if($data["restart"] || $_POST["edit_hall"] ){
			foreach(Seat::getSeatsMap($og_number, $_SESSION["cinema"]) as $seat){
				$seats_map[$seat->getNumRows()][$seat->getNumCol()] = $seat->getState();
				if($seat->getState()>=0){
					$seats++;
				}
			}
		}//Show the checkbox seats_map updated and everything to selected if alltoone was pressed 
		else{
			$alltoone = $_POST["alltoone"] ?? 0;
			for($i = 1;$i <= $rows; $i++){
				for($j = 1; $j <= $cols; $j++){ 
					echo "El valor de la data: ".$data["checkbox".$i.$j];
					if($alltoone || ( $data["checkbox".$i.$j] >= "0")){
						$seats_map[$i][$j] = $data["checkbox".$i.$j] ?? "0";
						$seats++;
					}else 
						$seats_map[$i][$j] = "-1";
				}	
		}
			
			
			
		}
		
		$htmlErroresGlobales = self::generaListaErroresGlobales($errores);
		$errorNumber = self::createMensajeError($errores, 'number', 'span', array('class' => 'error'));
		$errorSeats = self::createMensajeError($errores, 'seats', 'span', array('class' => 'error'));
		
		$html = '<div class="column left">
				'.$htmlErroresGlobales.'
					'.$errorSeats.'
					<fieldset>
						<legend>Configuracion</legend>
						<label> Filas: </label> <input type="number" name="rows" min="1" id="rows" value="'.$rows.'" required/> <br>
						<label> Columnas: </label> <input type="number" name="cols" min="1" id="cols" value="'.$cols.'"required/> <br>
						<label> Asientos totales:'.$seats.' </label> <input type="hidden" name="seats" id="seats" value="'.$seats.'"readonly/> <br>
						<input type="submit" id="submit" name="alltoone" value="Activar todos los asientos" class="primary" />';
						if($this->option == "edit_hall")
								$html .= '<input type="submit" id="restart" name="restart" value="Restaurar mapa original" class="primary" /> ';						
					$html .='</fieldset>
					<input type="submit" name="filter" value="Actualizar mapa de la sala" class="button large" /> 
					'.$errorNumber.'
					<fieldset>
						<label> Numero de sala: </label>
						<input type="number" min="1" name="number" id="number" value="'.$number.'" placeholder="Numero de la Sala" /><br>		
						<input type="hidden" min="1" name="og_number" value="'.$og_number.'" /><br>	
					</fieldset>	
					';
		if($this->option == "new_hall")
				$html .='<input type="submit" id="submit" name="sumbit" value="Crear Sala" class="primary" />';
		if($this->option == "edit_hall"){
				$html .='<input type="submit" id="submit" name="sumbit" value="Editar Sala" class="primary" />
						<input type="submit" id="submit" name="delete" value="Eliminar Sala" class="primary" />  
				';	
		}
			$html .='	</div>
				<div class="column right">
					<h3 class="table_title"> Pantalla </h3>
					<table class="seat">
					<thead>
						<tr>
							<th></th>';
			for($j = 1; $j<=$cols; $j++){
				$html .= '<th>'.$j.'</th>';	
			}
				$html .= '</tr>
					</thead>
					<tbody>';
				for($i = 1;$i<=$rows;$i++){
						$html .= '
						<tr>
						<td>'.$i.'</td>
						';
					for($j=1; $j<=$cols; $j++){
						if($seats_map[$i][$j]>=0){
							$html .= '<td> <input type="checkbox" class="check_box" name="checkbox'.$i.$j.'" value="'.$seats_map[$i][$j].'" id="checkbox'.$i.$j.'" checked> <label for="checkbox'.$i.$j.'"> </td>
							';}
						else {
							$html .= '<td> <input type="checkbox" class="check_box" name="checkbox'.$i.$j.'" value="'.$seats_map[$i][$j].'" id="checkbox'.$i.$j.'" > <label for="checkbox'.$i.$j.'"> </td>
							';}
					}
						$html .='
						</tr>';
				}
					
		$html .= '
					</tbody>
					</table>
				</div>
				';		

		return $html;
	}
	
    //Methods:

    //Process form:
   protected function procesaFormulario($datos){
        $result = array();
       
		$rows = $datos['rows'];
        $cols = $datos['cols'];
		$og_number = $datos["og_number"];
		
		//Prepare the seat_map
		$seats_map = array();
		$seats = 0;
		for($i = 1;$i <= $rows; $i++){
			for($j = 1; $j <= $cols; $j++){ 
				if(isset($datos["checkbox".$i.$j])){
					$seats_map[$i][$j] = $datos["checkbox".$i.$j];
					$seats++;
					if($seats_map[$i][$j] == "-1"){
						$seats_map[$i][$j] = "0";
					}
				}else{
					$seats_map[$i][$j] = "-1";
				}
			}	
		}
		
		if ($seats == 0 && isset($datos["sumbit"]) ) {
            $result['seats'] = "<li> No puede haber 0 asientos disponibles. </li> <br>";
        }
		
        $number = $datos['number'] ?? null;
		if (empty($number) && isset($datos["sumbit"])) {
            $result['number'] = "<li> El numero de sala tiene que ser mayor que 0. </li> <br>";
        }
		
        if (count($result) === 0 && isset($datos["sumbit"]) ) {
			if($this->option == "new_hall"){
                $_SESSION['msg'] = Hall::create_hall($number, $_SESSION["cinema"], $rows, $cols, $seats, $seats_map);
                $result = './?state=success';
            }
			if($this->option == "edit_hall"){
                $_SESSION['msg'] = Hall::edit_hall($number, $_SESSION["cinema"], $rows, $cols, $seats, $seats_map, $og_number);
                $result = './?state=success';
            }
        }
		
		if (!isset($result['number']) && isset($datos["delete"]) ) {
			if($this->option == "edit_hall"){
                $_SESSION['msg'] = Hall::delete_hall($number, $_SESSION["cinema"], $rows, $cols, $seats, $seats_map, $og_number);
                $result = './?state=success';
            }
        }
		
 
        return $result;
    }
}

?>

