<?php
	require_once('../assets/php/dao.php');
	include_once('film_dto.php');

    class Film_DAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Session.
		public function createFilm($id, $tittle, $duration, $language){

			$sql = sprintf( "INSERT INTO film( $id, $tittle, $duration, $language) 
								VALUES ( '%d', '%s', '%d', '%s')", 
									$id, $tittle, $duration, $language);

			return $sql;
		}

		//Returns a query to get the film's data.
		public function FilmData($id){
			$sql = sprintf( "SELECT * FROM film WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
		
	    	//Returns a query to get All the films.
		public function allFilmData(){
			$sql = sprintf( "SELECT * FROM film ");
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
	    
		//Create a new film Data Transfer Object.
		public function loadFilm($id, $tittle, $duration, $language){
			return new FilmDTO( $id, $tittle, $duration, $language);
		}
	    	
    }

?>
