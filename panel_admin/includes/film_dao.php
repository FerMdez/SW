<?php
	include_once('../assets/php/dao.php');
	include_once('film_dto.php');

    class FilmDAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Session.
		public function createFilm($id, $tittle, $duration, $language, $description){

			$sql = sprintf( "INSERT INTO film(tittle, duration, language, description) 
								VALUES ('%s', '%d', '%s', '%s')", 
									$tittle, $duration, $language, $description);
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
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
			while($fila=mysqli_fetch_array($resul)){
				$films[] = $this->loadFilm($fila["id"], $fila["tittle"],$fila["duration"],$fila["language"],$fila["description"]);
			}
			return $films;
		}
	    
		//Create a new film Data Transfer Object.
		public function loadFilm($id, $tittle, $duration, $language, $description){
			return new FilmDTO( $id, $tittle, $duration, $language, $description);
		}

		/*public function addFilm($films) {
			$resul =  mysqli_query($this->mysqli, $this->createFilm($film.getId(), $film.getTittle(), $film.getDuration(), $film.getLanguage(), $film.getDescription())) or die ('Error into query database');
			return $resul;
		}*/

		public function deleteFilm($id){
			
			$sql = sprintf( "DELETE FROM film WHERE film.id = '%d' ;",$id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
		
		public function editFilm($id, $tittle, $duration, $language,$description){
			$sql = sprintf( "UPDATE film
							SET tittle = '%s' , duration = '%d', language ='%s' , description ='%s'
							WHERE film.id = '%d';", 
							$tittle,$duration,$language, $description,$id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}

	
		//Returns a query to get all films tittles.
		public function tittleFilmData(){
			$sql = sprintf( "SELECT DISTINCT tittle FROM film ");
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
	    	
    }

?>