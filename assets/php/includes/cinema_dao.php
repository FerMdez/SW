<?php
	include_once('cinema.php');

    class Cinema_DAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Session.
		public function createCinema($id, $name, $direction, $phone){
			$sql = sprintf( "INSERT INTO `cinema`( `id`, `name`, `direction`, `phone`) 
								VALUES ( '%d', '%s', '%s', '%s')", 
									$id, $name, $direction, $phone);
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}
		
		
	    //Returns a query to get All the films.
		public function allCinemaData(){
			$sql = sprintf( "SELECT * FROM cinema ");
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			while($fila=$resul->fetch_assoc()){
				$films[] = $this->loadCinema($fila["id"], $fila["name"], $fila["direction"], $fila["phone"]);
			}
			$resul->free();
			return $films;
		}

		//Returns a  film data .
		public function GetCinema($name,$direction){
			$sql = sprintf( "SELECT * FROM cinema WHERE cinema.name = '%s'AND cinema.direction='%s'", $name,$direction );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}

		//Returns a  film data .
		public function cinemaData($id){
			$id = $this->mysqli->real_escape_string($id);

			$sql = sprintf( "SELECT * FROM cinema WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			$resul->data_seek(0);
			$film = null;
			while($fila=$resul->fetch_assoc()){
				$cinema = $this->loadCinema($fila["id"], $fila["name"], $fila["direction"], $fila["phone"]);
			}
			$resul->free();

			return $cinema;
		}

		public function existCinema($id){
			$id = $this->mysqli->real_escape_string($id);

			$sql = sprintf( "SELECT * FROM cinema WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}

		//Deleted film by "id".
		public function deleteCinema($id){
			$sql = sprintf( "DELETE FROM cinema WHERE cinema.id = '%d' ;",$id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
		
		//Edit a film.
		public function editCinema($id, $name, $direction, $phone){
			$sql = sprintf( "UPDATE cinema SET name = '%s' , direction = '%s', phone ='%s' 
								WHERE cinema.id = '%d';", 
									$name, $direction, $phone, $id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Get sessions associated with a cinema.
		public function getSessions($id){
			include_once('session_dao.php');
			$session = new SessionDAO("complucine");

			$sql = sprintf( " SELECT DISTINCT * FROM session WHERE session.id in 
								(SELECT session.id FROM session JOIN cinema ON session.idcinema = cinema.id WHERE cinema.id = '%d'); ", $id);
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			$sessions = null;
			while($fila = $resul->fetch_assoc()){
				$sessions[] = $session->loadSession($fila["id"], $fila["idfilm"], $fila["idhall"], $fila["idcinema"], $fila["date"], $fila["start_time"], $fila["seat_price"], $fila["format"], $fila["seats_full"]);
			}
			$resul->free();

			return $sessions;
		}
	    
		//Create a new film Data Transfer Object.
		public function loadCinema($id, $name, $direction, $phone){
			return new Cinema($id, $name, $direction, $phone);
		}
	    	
    }

?>
