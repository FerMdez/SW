<?php

require('../panel_admin/includes/film_dao.php');


class ListFilms{
	
    //Atributes:
	private $array;
	private $size;

    //Constructor:
    public function __construct() {
        $this->array = array();
		$this->updateArray();
    }
    //Methods:

    //Returns the whole session array
    public function getArray() {
        return $this->array;
    }
	
	//Returns the value i from the array
    public function getiArray($i) {
		if($i < $size){
			return $this->array($i);
		} else {
			return null;
		}
		
    }

    //Update the array with new values
    public function updateArray() {
		
		$bd = new Film_DAO('complucine');
		
		if($bd){
			$selectFilms = $bd->allFilmData();
			$selectFilms->data_seek(0);
			$this->size = 0;
			while ($fila = $selectFilms->fetch_assoc()) {
                $this->array[]= new Film_DTO($fila['id'], $fila['tittle'], $fila['duration'], $fila['language'], "no hay descripcion en la base de datos");
				$this->size++;
			}
			mysqli_free_result($selectFilms);	
		}
    }

}

?>