<?php
	include_once('film.php');

    class Film_DAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Session.
		public function createFilm($id, $tittle, $duration, $language, $description, $img){
			$sql = sprintf( "INSERT INTO `film`( `id`, `tittle`, `duration`, `language`,`description`, `img`) 
								VALUES ( '%d', '%s', '%d', '%s','%s', '%s')", 
									$id, $tittle, $duration, $language, $description, $img);
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}
		//Returns a  film data .
		public function GetFilm($tittle,$language){
			$sql = sprintf( "SELECT * FROM film WHERE film.tittle = '%s'AND film.language='%s'", $tittle,$language );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}

		//Returns the film's data by ID.
		public function FilmData($id){
			$id = $this->mysqli->real_escape_string($id);

			$sql = sprintf( "SELECT * FROM film WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			$resul->data_seek(0);
			$film = null;
			while ($fila = $resul->fetch_assoc()) {
				if($id === $fila['id']){
					$film = $this->loadFilm($fila["id"], $fila["tittle"], $fila["duration"], $fila["language"], $fila["description"], $fila["img"]);
				}
			}

			//mysqli_free_result($selectUser);
			$resul->free();

			return $film;
		}
		
	    //Returns a query to get All the films.
		public function allFilmData(){
			$sql = sprintf( "SELECT * FROM film ");
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			while($fila=$resul->fetch_assoc()){
				$films[] = $this->loadFilm($fila["id"], $fila["tittle"], $fila["duration"], $fila["language"], $fila["description"], $fila["img"]);
			}
			$resul->free();
			return $films;
		}


		//Returns a query to get all films tittles.
		public function tittleFilmData(){
			$sql = sprintf( "SELECT DISTINCT tittle FROM film ");
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Returns a query to get all films descriptions.
		public function descriptionFilmData(){
			$sql = sprintf( "SELECT description FROM film ");
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		/*
		public function addFilm($films) {
			$resul =  mysqli_query($this->mysqli, $this->createFilm($film.getId(), $film.getTittle(), $film.getDuration(), $film.getLanguage(), $film.getDescription())) or die ('Error into query database');
			return $resul;
		}
		*/

		//Deleted film by "id".
		public function deleteFilm($id){
			$sql = sprintf( "DELETE FROM film WHERE film.id = '%d' ;",$id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
		
		//Edit a film.
		public function editFilm($id, $tittle, $duration, $language,$description,$img){
			$sql = sprintf( "UPDATE film SET tittle = '%s' , duration = '%d', language ='%s' , description ='%s', img ='%s'
								WHERE film.id = '%d';", 
									$tittle, $duration, $language, $description, $img, $id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Get cinemas associated with a movie.
		public function getCinemas($id){
			include_once('cinema_dao.php');
			$cinema = new Cinema_DAO("complucine");

			$sql = sprintf( " SELECT DISTINCT * FROM cinema WHERE cinema.id in 
								(SELECT session.idcinema FROM session JOIN film ON session.idfilm = film.id WHERE film.id = '%d'); ", $id);
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			$cinemas = null;
			while($fila = $resul->fetch_assoc()){
				$cinemas[] = $cinema->loadCinema($fila["id"], $fila["name"], $fila["direction"], $fila["phone"]);
			}
			$resul->free();

			return $cinemas;
		}

		//Get sessions associated with a film.
		public function getSessions($id){
			include_once('session_dao.php');
			$session = new SessionDAO("complucine");

			$sql = sprintf( " SELECT DISTINCT * FROM session WHERE session.id in 
								(SELECT session.id FROM session JOIN film ON session.idfilm = film.id WHERE film.id = '%d'); ", $id);
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			$sessions = null;
			while($fila = $resul->fetch_assoc()){
				$sessions[] = $session->loadSession($fila["id"], $fila["idfilm"], $fila["idhall"], $fila["idcinema"], $fila["date"], $fila["start_time"], $fila["seat_price"], $fila["format"], $fila["seats_full"]);
			}
			$resul->free();

			return $sessions;
		}
	    
		//Create a new film Data Transfer Object.
		public function loadFilm($id, $tittle, $duration, $language,$description, $img){
			return new Film( $id, $tittle, $duration, $language,$description, $img);
		}
	    	
    }

?>
