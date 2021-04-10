<?php

include_once('session_dao.php');
include_once('../assets/php/form.php');

class FormSession extends Form {

    //Atributes:
    private $correct;  // Indicates if the session is correct.
    private $reply; // Validation response
	
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
			$this->reply = "<h1> Operacion realizada con exito </h1><hr />
						<p> Se ha añadido la sesion correctamente en la base de datos.</p>
						<a href='../panel_manager/index.php'><button>Panel Gerente</button></a>";
		} else {
			$this->reply = "<h1> ERROR  </h1><hr />
						<p> Ha habido un error en la operacion. Revisa los datos introducidos o ponte en contacto con el administrador de la base de datos.</p>
						<a href='../panel_manager/index.php'><button>Panel Gerente</button></a>";
			
		}
        return $this->reply;
    }

    //Process form:
    public function processesForm($price, $film, $format, $start) {
        $this->correct = true;
		$hall = 2;
		$cinema = 1;
		$date = "2021-04-10";
		//Habria que validar todo para que encaje en la base de datos
		
		$start = date('H:i:s', strtotime( $start ) );
        $date = date('Y-m-d', strtotime( $date ) );
		
		$bd = new sessionDAO('complucine');
		if($bd){
			$selectSession = $bd->selectSession($cinema, $hall, $start, $date);
			
			if($selectSession && $selectSession->num_rows >= 1)	{
				$this->correct = false;
				
			} else{	
				$bd->createSession(null, $film, $hall,$cinema, $date, $start, $price, $format);
			}

			mysqli_free_result($selectSession);	
		}
    }

}

?>

