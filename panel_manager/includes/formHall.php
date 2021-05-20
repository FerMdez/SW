<?php
include_once($prefix.'assets/php/includes/hall.php');
include_once($prefix.'assets/php/includes/seat.php');
include_once($prefix.'assets/php/form.php');
	
class FormHall extends Form {
	
	private $option;
	private $cinema;
	
    //Constructor:
    public function __construct($option, $cinema) {
		$this->option = $option;
		$this->cinema = $cinema;
		$options = array("action" => "./?state=".$option);
        parent::__construct('formHall',$options);
    }
	
	protected function generaCamposFormulario($data, $errores = array()){
		//Prepare the data
		$number = $data['number'] ?? $_POST["number"] ?? "";
		$rows = $data['rows'] ?? $_POST["rows"] ?? "12";
		$cols = $data['cols'] ?? $_POST["cols"] ?? "8";
		$og_number = $data['og_number'] ?? $number;
		$og_rows = $data['og_rows'] ?? $rows;
		$og_cols = $data['og_cols'] ?? $cols;
		
		//Seats_map
		$seats = 0;
		$seats_map = array();
		for($i = 1;$i <= $rows; $i++){
			for($j = 1; $j <= $cols; $j++){ 
				$seats_map[$i][$j] = "-1";
			}
		}
		
		//Show the original seats_map once u click restart or the first time u enter this form from manage_halls's form
		if(isset($data["restart"]) || isset($_POST["edit_hall"]) ){
			$rows = $og_rows;
			$cols = $og_cols;
			$seat_list = Seat::getSeatsMap($og_number, $this->cinema);
			if($seat_list){
				foreach($seat_list as $seat){
					$seats_map[$seat->getNumRows()][$seat->getNumCol()] = $seat->getState();
					if($seat->getState()>=0){
						$seats++;
					}
				}
			}
		}//Show the checkbox seats_map updated and everything to selected if alltoone was pressed 
		else{
			$alltoone = $_POST["alltoone"] ?? 0;
			for($i = 1;$i <= $rows; $i++){
				for($j = 1; $j <= $cols; $j++){ 
					if($alltoone || isset($data["checkbox".$i.$j])) {
						$seats_map[$i][$j] = $data["checkbox".$i.$j] ?? "0";
						$seats++;
						if($seats_map[$i][$j] == "-1"){
							$seats_map[$i][$j] = "0";
						}
					}else 
						$seats_map[$i][$j] = "-1";
				}	
			}
		}
		
		$htmlErroresGlobales = self::generaListaErroresGlobales($errores);
		$errorNumber = self::createMensajeError($errores, 'number', 'span', array('class' => 'error'));
		$errorSeats = self::createMensajeError($errores, 'seats', 'span', array('class' => 'error'));
		$errorRows = self::createMensajeError($errores, 'rows', 'span', array('class' => 'error'));
		$errorCols = self::createMensajeError($errores, 'cols', 'span', array('class' => 'error'));
		
		$html = '
				<div class="column left">'.$htmlErroresGlobales.' 
					<fieldset>
						<legend>Mapa de Asientos</legend>
						'.$errorSeats.' '.$errorRows.' '.$errorCols.'
						<label> Filas: </label> <input type="number" name="rows" min="1" id="rows" value="'.$rows.'" required/> <br>
						<input type="Hidden" name="og_rows" value="'.$og_rows.'"/> <br>
						<label> Columnas: </label> <input type="number" name="cols" min="1" id="cols" value="'.$cols.'"required/> <br>
						<input type="Hidden" name="og_cols" value="'.$og_cols.'"/> <br>
						<label> Asientos totales:'.$seats.' </label> <input type="hidden" name="seats" id="seats" value="'.$seats.'"readonly/> <br>
						<input type="submit" name="alltoone" value="Activar todos los asientos" class="button large" />';
						if($this->option == "edit_hall")
								$html .= ' <input type="submit" id="restart" name="restart" value="Restaurar mapa original" class="black button" />';						
					$html .='
					</fieldset>
					<input type="submit" name="filter" value="Actualizar mapa de la sala" class="button large" /> '.$errorNumber.'
					<fieldset>
						<label> Numero de sala: </label>
						<input type="number" min="1" name="number" id="number" value="'.$number.'" placeholder="Numero de la Sala" /><br>		
						<input type="hidden" name="og_number" value="'.$og_number.'" /><br>	
					</fieldset>	
					';
		if($this->option == "new_hall")
				$html .='<input type="submit" id="submit" name="sumbit" value="Crear Sala" class="primary" />
				';
		if($this->option == "edit_hall"){
				$html .='<input type="submit" id="submit" name="sumbit" value="Editar Sala" class="primary" />
					<input type="submit" id="submit" name="delete" onclick="return confirm(\'Seguro que quieres borrar esta sala?\')" value="Eliminar Sala" class="black button" />  
				';	
		}
		if(!$errorCols && !$errorRows){
			$html .='</div>
				<div class="column right">
					<h3 class="table_title"> Pantalla </h3>
					<table class="seat">
						<thead>
							<tr>
								<th> </th>
								';
			for($j = 1; $j<=$cols; $j++){
				$html .= '<th>'.$j.'</th>
								';	
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
						$html .='</tr>';
				}
					
		$html .= '
						</tbody>
					</table>
				</div>';		
		} else
			$html .='</div>';
			
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
		
		if ($rows <= 0) {
            $result['rows'] = "<li> No puede haber 0 o menos filas. </li> <br>";
        }
		
		if ($cols <= 0) {
            $result['cols'] = "<li> No puede haber 0 o menos columnas. </li> <br>";
        }
		
		
        $number = $datos['number'] ?? null;
		if (empty($number) && isset($datos["sumbit"])) {
            $result['number'] = "<li> El numero de sala tiene que ser mayor que 0. </li> <br>";
        }
		
        if (count($result) === 0 && isset($datos["sumbit"]) ) {
				if($this->option == "new_hall"){
					$_SESSION['msg'] = Hall::create_hall($number, $this->cinema, $rows, $cols, $seats, $seats_map);
					$result = './?state=success';
				}
				if($this->option == "edit_hall"){
					$_SESSION['msg'] = Hall::edit_hall($number,$this->cinema, $rows, $cols, $seats, $seats_map, $og_number);
					$result = './?state=success';
				}
        }
		
		if (!isset($result['number']) && isset($datos["delete"]) ) {
			if($this->option == "edit_hall"){
                $_SESSION['msg'] = Hall::delete_hall($number, $this->cinema, $rows, $cols, $seats, $seats_map, $og_number);
                $result = './?state=success';
            }
        }
		
 
        return $result;
    }
}

?>

