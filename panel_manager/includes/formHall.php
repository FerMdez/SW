<?php
include_once($prefix.'assets/php/common/hall_dao.php');
include_once($prefix.'assets/php/form.php');

class FormHall extends Form {

    //Atributes:
    private $correct;  
    private $reply; 
	private $option;
	private $halls;
	
    //Constructor:
    public function __construct() {
        parent::__construct('formSession');
        $this->reply = array();
    }
	
	public static function generaCampoFormulario($datos, $errores = array(), $option){
		if($option == "new"){
			$number = $datos['number'] ?? '';
			$rows = $datos['rows'] ?? '';
			$cols = $datos['cols'] ?? '';
			$seats = $datos['seats'] ?? '';
			
			
			$htmlform .= '
				<form method="post" id="new_hall" action="./includes/processForm.php"\>
					<fieldset>
						<label>Numero de sala:</label> <input type="number" name="number" value="'.$number.'" required/> <br>
						<label>Filas:</label> <input type="number" name="rows" value= "'.$rows.'" required/><br>
						<label>Columnas:</label> <input type="number" name="cols" value= "'.$cols.'" required/><br>
						<label>Butacas totales:</label> <input type="number" name="seats" value= "'.$seats.'"/><br>
						<button type="submit" name="new_hall" class="button large">Crear</button></div><br>
					</fieldset>
				</form>
				';
		}
		
		
		return $htmlform;	
	}
    //Methods:

    //Returns validation response:
    public function getReply() {
		
		if($this->correct){
			if($this->option == "new"){
				$this->reply = "<h1> Operacion realizada con exito </h1><hr />
						<p> Se ha añadido la sala correctamente en la base de datos.</p>
						<a href='../panel_manager/index.php'><button>Panel Gerente</button></a>";
			}else if($this->option == "edit"){
								$this->reply = "<h1> Operacion realizada con exito </h1><hr />
						<p> Se ha editado la sala correctamente en la base de datos.</p>
						<a href='../panel_manager/index.php'><button>Panel Gerente</button></a>";
			}else if($this->option == "del"){
								$this->reply = "<h1> Operacion realizada con exito </h1><hr />
						<p> Se ha eliminado la sala correctamente en la base de datos.</p>
						<a href='../panel_manager/index.php'><button>Panel Gerente</button></a>";
			}else if($this->option == "list"){
								$this->reply = $this->halls;
			}
		} else {
			$this->reply = "<h1> ERROR  </h1><hr />
						<p> Ha habido un error en la operacion. Revisa los datos introducidos o ponte en contacto con el administrador de la base de datos.</p>
						<a href='../panel_manager/index.php'><button>Panel Gerente</button></a>";
		}
        return $this->reply;
    }

    //Process form:
    public static function processesForm($data){
		if($data["option"] == "new"){
			Hall::create_hall($data);
			$_SESSION['msg'] = "La sala se ha añadido correctamente";
			header( "Location: ../?state=success" );
		}else {
			/* TODO
			$start = date('H:i:s', strtotime( $start ) );
			
			if($option == "new"){
				
				$selectSession = $bd->selectSession($cinema, $hall, $start, $date);
				if($selectSession && $selectSession->num_rows >= 1)	{
					$this->correct = false;
				} else{	
					$bd->createSession(null, $film, $hall,$cinema, $date, $start, $price, $format);
				}
				
			mysqli_free_result($selectSession);
			
			} else if ($option == "del"){
				$bd->deleteSession($id);
				
			} else if ($option == "edit"){
				$bd->editSession($id, $film, $hall, $cinema, $date, $start, $price, $format);
			}
			
			if($repeat > "0"){
				$repeat--;
				$date = date('Y-m-d', strtotime( $date. ' +1 day') );
				$this->processesForm($film, $hall, $cinema, $date, $start, $price, $format, $repeat);
			}		
			*/
		}			
    }
}

?>

