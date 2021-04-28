<?php

include_once('../assets/php/config.php');
include_once('../assets/php/common/film_dao.php');
include_once('../assets/php/common/film_dto.php');
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
	public function processesForm($_id,$_tittle,$_duration,$_language,$_description, $_option) {
		$this->correct = true;
		$this->option = $_option;

		$id= $this->test_input($_id);
		$tittle=$this->test_input($_tittle);
		$duration=$this->test_input($_duration);
		$language=$this->test_input($_language);
		$description=$this->test_input($_description);
	
		//Habria que validar todo para que encaje en la base de datos
			
		$bd = new Film_DAO('complucine');
		if($bd){
			if($this->option == "new"){
				 //Primero comprobar si los campos no son vacios y la duracion es mayor que 0
				if(!empty($tittle)&&$duration>0&&!empty($language)&&!empty($description)){
					// comprobar si existe una pelicula con el mismo titulo e idioma
					$exist = $bd-> GetFilm($tittle,$language);
					if( mysqli_num_rows($exist) != 0){
						$this->correct =false;
					}
					else{
						$bd->createFilm(null, $tittle,$duration,$language,$description);

					}
					$exist->free();
				}
				else{
					$this->correct =false;
				}	
			} else if ($this->option == "del"){
				//Primero comprobar si existe una pelicula con el mismo id
				$exist = $bd-> FilmData($id);
				if( mysqli_num_rows($exist) == 1){
					$bd->deleteFilm($id);
				}
				else{
					$this->correct =false;
				}
			} else if ($this->option == "edit"){
				 //Primero comprobar si los campos no son vacios y la duracion es mayor que 0
				if(!empty($tittle)&&$duration>0&&!empty($language)&&!empty($description)){
					//comprobar si existe una pelicula con el mismo id
					$exist = $bd-> FilmData($id);
					if( mysqli_num_rows($exist) == 1){
						$bd->editFilm($id,$tittle,$duration,$language,$description);
					}
					else{
						$this->correct =false;
					}
					$exist->free();
				}
				else{
					$this->correct =false;
				}
			}  else if($this->option == "show") {
				$this->array = $bd->allFilmData();
			}
			else {$this->correct = false;}			
		}
		
	
	}

	protected function test_input($input){
		return htmlspecialchars(trim(strip_tags($input)));
	}
}


?>