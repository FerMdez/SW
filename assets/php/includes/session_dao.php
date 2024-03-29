<?php
	include_once('session.php');
	
    class SessionDAO extends DAO {
		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }
		
		//Create a new Session  taking the new id,film, hall, cinema, date, start time, seat price and format saving in the database
		public function createSession($id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format){
			$format = $this->mysqli->real_escape_string($format);	
			$date = date('Y-m-d', strtotime( $date ) ); 
			$startTime = date('H:i:s', strtotime( $startTime ) );
			
			$sql = sprintf( "INSERT INTO `session` (`id`, `idfilm`, `idhall`, `idcinema`, `date`, `start_time`, `seat_price`, `format`, `seats_full`) 
				VALUES ('%d', '%d', '%d', '%d', '%s', '%s', '%d', '%s', '%d')",
					$id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, "0");
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error createSession');
			
			return $sql;
		}

		//Returns a query to get the session's data.
		public function sessionData($id){
			$sql = sprintf( "SELECT * FROM `session` WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error accessing to the session with id '. $id);

			while($fila=$resul->fetch_assoc()){
				$session = $this->loadSession($fila["id"], $fila["idfilm"], $fila["idhall"], $fila["idcinema"], $fila["date"], $fila["start_time"], $fila["seat_price"], $fila["format"], $fila["seats_full"]);
			}
			$resul->free();

			return $session;
		}	
		
		//Look for a film with the id film
		public function filmTittle($idfilm){
			$sql = sprintf("SELECT * FROM film JOIN  session ON film.id = session.idfilm WHERE session.idfilm = '%d' ", $idfilm );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error accessing to the film with id '. $idfilm);
			
			$resul = mysqli_fetch_array($resul);
			
			return $resul;
		}	
		
		//Look for a session with the primary key 
		public function searchSession($cinema, $hall, $startTime, $date){
			$date = date('Y-m-d', strtotime( $date ) ); 
			$startTime = date('H:i:s', strtotime( $startTime ) );
			

			$sql = sprintf( "SELECT * FROM session WHERE 
							idcinema = '%s' AND idhall = '%s' AND date = '%s' AND start_time = '%s'", 
							$cinema, $hall, $date, $startTime);	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error searching for a session');
			
			$session = mysqli_fetch_array($resul);
			
			mysqli_free_result($resul);
			
			return $session;
		}
		
		public function searchSessionActivesAtStartTimeAndFilmDuration($cinema, $hall, $startTime, $date, $idfilm){
			$date = date('Y-m-d', strtotime( $date ) ); 
			$startTime = date('H:i:s', strtotime( $startTime ) );
			$sessions = [];
			
			$sql = sprintf("SELECT duration FROM film WHERE id='%s'", $idfilm );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error looking for the film duration of id '. $idfilm);
			
			$duration = ($resul->fetch_assoc())["duration"]+10;
			$endHour = date('H:i:s', strtotime( $startTime . ' +'.$duration.' minute'));
			
			$sql = sprintf( "SELECT * FROM session WHERE 
					idcinema = '%s' AND idhall = '%s' AND date = '%s' AND start_time BETWEEN '%s' AND '%s' ORDER BY start_time ASC;", 
					$cinema, $hall, $date, $startTime, $endHour);	
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error looking for sessions between start time and start time + film duration');
			
			while($fila=$resul->fetch_assoc()){
				$sessions[] = $this->loadSession($fila["id"], $fila["idfilm"], $fila["idhall"], $fila["idcinema"], $fila["date"], $fila["start_time"], $fila["seat_price"], $fila["format"], $fila["seats_full"]);
			}
			mysqli_free_result($resul);

			return $sessions;
		}
		
		
		//Returns a query to get all the session's data.
		public function getAllSessions($hall, $cinema, $date, $end){
			if($end){

				$sql = sprintf( "SELECT * FROM session WHERE 
								idcinema = '%s' AND idhall = '%s' AND date BETWEEN '%s' AND '%s' ORDER BY start_time ASC;", 
								$cinema, $hall, $date, $end);	
			}else if($date && !$end){
				$date = date('Y-m-d', strtotime( $date ) ); 
				
				$sql = sprintf( "SELECT * FROM session WHERE 
								idcinema = '%s' AND idhall = '%s' AND date = '%s' ORDER BY start_time ASC;", 
								$cinema, $hall, $date);	
			}else{
				$sql = sprintf( "SELECT * FROM session WHERE 
								idcinema = '%s' AND idhall = '%s' ORDER BY start_time ASC;", 
								$cinema, $hall);	
			}
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error geting all sessions');
			
			$sessions = null;
			while($fila=$resul->fetch_assoc()){
				$sessions[] = $this->loadSession($fila["id"], $fila["idfilm"], $fila["idhall"], $fila["idcinema"], $fila["date"], $fila["start_time"], $fila["seat_price"], $fila["format"], $fila["seats_full"]);
			}
			mysqli_free_result($resul);
			
			return $sessions;
		}
		
		//Look for a title and cinema
		public function getSessions_Film_Cinema($idFiml, $idCinema){
			$sql = sprintf( "SELECT * FROM session WHERE session.idfilm = '%d' AND session.idcinema = '%d' ", $idFiml, $idCinema);
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error geting sessions with a idfilm and cinema');

			$sessions = null;
			while($fila = $resul->fetch_assoc()){
				$sessions[] = $this->loadSession($fila["id"], $fila["idfilm"], $fila["idhall"], $fila["idcinema"], $fila["date"], $fila["start_time"], $fila["seat_price"], $fila["format"], $fila["seats_full"]);
			}
			$resul->free();

			return $sessions;
		}
		
		//Edit a session taking the new film, hall, date, start time, seat price and format with respect to its origin parameter
        public function editSession($idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, $origin){
			$format = $this->mysqli->real_escape_string($format);
			$date = date('Y-m-d', strtotime( $date ) ); 
			$origin["date"] = date('Y-m-d', strtotime( $origin["date"] ) ); 
			$startTime = date('H:i:s', strtotime( $startTime ) );
			$origin["start"] = date('H:i:s', strtotime( $origin["start"] ) ); 
			
            $sql = sprintf( "UPDATE `session`
                             SET `idfilm` = '%d' , `idhall` = '%d', `idcinema` = '%d', `date` = '%s',
                                  `start_time` = '%s', `seat_price` = '%d', `format` = '%s'
                             WHERE 
								idcinema = '%s' AND idhall = '%s' AND session.date = '%s' AND start_time = '%s'", 
                $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, $origin["cinema"],$origin["hall"],$origin["date"],$origin["start"]);
			

			mysqli_query($this->mysqli, $sql) or die ('Error editing a session');
			
        }

		//Delete a session whit the primary key
        public function deleteSession($hall, $cinema, $date, $startTime){

            $sql = sprintf( "DELETE FROM `session` WHERE 
							idcinema = '%s' AND idhall = '%s' AND date = '%s' AND start_time = '%s'", 
							$cinema, $hall, $date, $startTime);	

            $resul = mysqli_query($this->mysqli, $sql) or die ('Error deleting a session');

            return $resul;
        }
		
		//Create a new Session Data Transfer Object.
		public function loadSession( $id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, $seats_full){
			return new Session( $id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, $seats_full);
		}

    }

?>
