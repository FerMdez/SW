<?php

include_once('film_dao.php');
include_once('../assets/php/form.php');

class FormFilm extends Form {

    //Atributes:
    private $correct;  // Indicates if the session is correct.
    private $reply; // Validation response
	private $option;
	private $array;
    //Constructor:
    public function __construct() {
        parent::__construct('formFilm');
        $this->reply = array();
    }



    public function getReply() {
		if($this->correct){
			if($this->option == "new"){
				$this->reply = "<h1> Operacion realizada con exito </h1><hr />
						<p> Se ha añadido la pelicula correctamente en la base de datos.</p>
						<a href='../panel_admin/index.php?state=mf'><button>Cerrar Mensaje</button></a>";
			}else if($this->option == "edit"){
								$this->reply = "<h1> Operacion realizada con exito </h1><hr />
						<p> Se ha editado la pelicula correctamente en la base de datos.</p>
						<a href='../panel_admin/index.php?state=mf'><button>Cerrar Mensaje</button></a>";
			}else if($this->option == "del"){
								$this->reply = "<h1> Operacion realizada con exito </h1><hr />
						<p> Se ha eliminado la pelicula correctamente en la base de datos.</p>
						<a href='../panel_admin/index.php?state=mf'><button>Cerrar Mensaje</button></a>";
			} else if($this->option == "show"){
					$this->reply= $this->array;
			}

		} else {
			$this->reply = "<h1> ERROR  </h1><hr />
						<p> Ha habido un error en la operacion. Revisa los datos introducidos</p>
						<a href='../panel_admin/index.php?state=mf'><button>Panel Admin</button></a>";
			
		}
        return $this->reply;
    }

    //Process form:
    public function processesForm($id,$title,$duration,$languaje,$description, $option) {
        $this->correct = true;
		$this->option = $option;

		//Habria que validar todo para que encaje en la base de datos
		
		$bd = new FilmDAO('complucine');
		if($bd ){
			if($option == "new"){
				$bd->createFilm(null, $title,$duration,$languaje,$description);
			} else if ($option == "del"){
				$bd->deleteFilm($id);
			} else if ($option == "edit"){
				$bd->editFilm($id,$title,$duration,$languaje,$description);
			} else if($this->option == "show") {
				$this->array = $bd->allFilmData();
			}
		} else {$this->correct = false;}		
		
    }

}

?>