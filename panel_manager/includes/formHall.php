<?php
include_once('hall_dao.php');
include_once('../assets/php/form.php');

class FormHall extends Form {

    //Atributes:
    private $correct;  // Indicates if the session is correct.
    private $reply; // Validation response
	private $option;
	private $halls;
	
    //Constructor:
    public function __construct() {
        parent::__construct('formSession');
        $this->reply = array();
    }

    //Methods:

    //Returns validation response:
    public function getReply() {
		//Habria que comprobar si realmente se ha validado la respuesta antes de escribir una respuesta correcta
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
    public function processesForm($number, $cinema, $rows, $cols, $option) {
		$this->option = $option;
		$this->correct = true;
		$bd = new HallDAO('complucine');
		
		
		if($bd ){
			if($option == "list"){
				$this->halls = $bd->getAllHalls($cinema);
			}else {
				/*
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
			
		} else {$this->correct = false;}	
    }
}

?>

