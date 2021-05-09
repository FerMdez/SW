<?php
	require_once($prefix.'assets/php/dao.php');
	include_once('session.php');
	
    class SessionDAO extends DAO {
		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }
		//Methods:
		
		public function createSession($id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format){
			$format = $this->mysqli->real_escape_string($format);	
			$date = date('Y-m-d', strtotime( $date ) ); 
			$startTime = date('H:i:s', strtotime( $startTime ) );
			
			$sql = sprintf( "INSERT INTO `session` (`id`, `idfilm`, `idhall`, `idcinema`, `date`, `start_time`, `seat_price`, `format`, `seats_full`) 
				VALUES ('%d', '%d', '%d', '%d', '%s', '%s', '%d', '%s', '%d')",
					$id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, "0");
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			
			return $sql;
		}

		//Returns a query to get the session's data.
		public function sessionData($id){
			$sql = sprintf( "SELECT * FROM `session` WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database en sessionData con la id '. $id);

			$resul = mysqli_fetch_array($resul);

			return $resul;
		}	
		
		public function filmTittle($idfilm){
			$sql = sprintf("SELECT * FROM film JOIN  session ON film.id = session.idfilm WHERE session.idfilm = '%d' ", $idfilm );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database en sessionData con la id '. $idfilm);
			
			$resul = mysqli_fetch_array($resul);
			
			return $resul;
		}	
		
		//Returns a session
		public function searchSession($cinema, $hall, $startTime, $date){
			$date = date('Y-m-d', strtotime( $date ) ); 
			$startTime = date('H:i:s', strtotime( $startTime ) );
			
			$sql = sprintf( "SELECT * FROM session WHERE 
							idcinema = '%s' AND idhall = '%s' AND date = '%s' AND start_time = '%s'", 
							$cinema, $hall, $date, $startTime);	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			
			$session = mysqli_fetch_array($resul);
			
			mysqli_free_result($resul);
			
			return $session;
		}
		//Returns a query to get all the session's data.
		public function getAllSessions($hall, $cinema, $date){
			$date = date('Y-m-d', strtotime( $date ) ); 
			
			$sql = sprintf( "SELECT * FROM session WHERE 
							idcinema = '%s' AND idhall = '%s' AND date = '%s' ORDER BY start_time ASC;", 
							$cinema, $hall, $date);	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			
			$sessions = null;
			
			while($fila=mysqli_fetch_array($resul)){
				$sessions[] = $this->loadSession($fila["id"], $fila["idfilm"], $fila["idhall"], $fila["idcinema"], $fila["date"], $fila["start_time"], $fila["seat_price"], $fila["format"], $fila["seats_full"]);
			}
			mysqli_free_result($resul);
			
			return $sessions;
		}
		
        public function editSession($idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, $origin){
			$format = $this->mysqli->real_escape_string($format);
			$date = date('Y-m-d', strtotime( $date ) ); 
			$startTime = date('H:i:s', strtotime( $startTime ) );
			
            $sql = sprintf( "UPDATE `session`
                             SET `idfilm` = '%d' , `idhall` = '%d', `idcinema` = '%d', `date` = '%s',
                                  `start_time` = '%s', `seat_price` = '%d', `format` = '%s'
                             WHERE 
								idcinema = '%s' AND idhall = '%s' AND date = '%s' AND start_time = '%s'", 
                $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, $origin["cinema"],$origin["hall"],$origin["date"],$origin["start"]);

            $resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

            return $resul;
        }

        public function deleteSession($hall, $cinema, $date, $startTime){

            $sql = sprintf( "DELETE FROM `session` WHERE 
							idcinema = '%s' AND idhall = '%s' AND date = '%s' AND start_time = '%s'", 
							$cinema, $hall, $date, $startTime);	

            $resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

            return $resul;
        }
		
		//Create a new Session Data Transfer Object.
		public function loadSession( $id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, $seats_full){
			return new Session( $id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, $seats_full);
		}

    }

?>
