<?php
include_once('session_dao.php');
include_once('../assets/php/form.php');

//Receive data from froms and prepare the correct response
class FormSession extends Form {
	//Atributes
    private $correct;
    private $reply; 
	private $option;
	private $sessions;
	
//Constructor:	
    public function __construct() {
        parent::__construct('formSession');
        $this->reply = array();
    }
	
	//Methods:
    public function getReply() {
		if($this->correct){
			if($this->option == "new"){
				$this->reply = "<h1> Operacion realizada con exito </h1><hr />
						<p> Se ha añadido la sesion correctamente en la base de datos.</p>
						<a href='../panel_manager/index.php'><button>Panel Gerente</button></a>";
			}else if($this->option == "edit"){
								$this->reply = "<h1> Operacion realizada con exito </h1><hr />
						<p> Se ha editado la sesion correctamente en la base de datos.</p>
						<a href='../panel_manager/index.php'><button>Panel Gerente</button></a>";
			}else if($this->option == "del"){
								$this->reply = "<h1> Operacion realizada con exito </h1><hr />
						<p> Se ha eliminado la sesion correctamente en la base de datos.</p>
						<a href='../panel_manager/index.php'><button>Panel Gerente</button></a>";
			}else if($this->option == "list"){
								$this->reply = $this->sessions;
			}
		} else if($this->correct == false) {
			$this->reply = "<h1> ERROR  </h1><hr />
						<p> Ha habido un error en la operacion. Revisa los datos introducidos o ponte en contacto con el administrador de la base de datos.</p>
						<a href='../panel_manager/index.php'><button>Panel Gerente</button></a>";
		}
        return $this->reply;
    }

    public function processesForm($film, $hall, $cinema, $date, $start, $price, $format, $repeat, $option) {
		$this->option = $option;
		$this->correct = true;

		$bd = new sessionDAO('complucine');
				
		if($bd ){
			if($option == "list"){
				$this->sessions = $bd->getAllSessionsFromACinemaHallDate($cinema, $hall, $date);
				
			}else {
				if($option == "new"){
					$searchSession = $bd->searchSession($cinema, $hall, $start, $date);
					if($searchSession)	{
						$this->correct = false;
					} else{	
						$bd->createSession(null,$film, $hall,$cinema, $date, $start, $price, $format);
					}
				
				} else if ($option == "del"){
					$bd->deleteSession($hall, $cinema, $date, $start);
					
				} else if ($option == "edit"){
					$bd->editSession($film, $hall, $cinema, $date, $start, $price, $format);
		
				}
				
				if($repeat > "0"){
					$repeat--;
					$date = date('Y-m-d', strtotime( $date. ' +1 day') );
					$this->processesForm($film, $hall, $cinema, $date, $start, $price, $format, $repeat, $option);
				}		
			}		
		} else {$this->correct = false;}	
    }
}

?>

