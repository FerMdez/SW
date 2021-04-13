<?php
	require_once('../assets/php/dao.php');
	include_once('session_dto.php');

    class SessionDAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Session.
		public function createSession($id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format){
			
			$sql = sprintf( "INSERT INTO `session` (`id`, `idfilm`, `idhall`, `idcinema`, `date`, `start_time`, `seat_price`, `format`) 
				VALUES ('%d', '%d', '%d', '%d', '%s', '%s', '%d', '%s')",
					$id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format);
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			
			return $sql;
		}

		//Returns a query to get the session's data.
		public function sessionData($id){
			$sql = sprintf( "SELECT * FROM `session` WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database en sessionData con la id '. $id);

			return $resul;
		}
		
		//Returns a query to check if the session in this cinema, hall and scheudle exists.
		public function selectSession($cinema, $hall, $start, $date){
			if($start == null){	
				$sql = sprintf( "SELECT * FROM session WHERE 
							idcinema = '%s' AND idhall = '%s' AND date = '%s'", 
							$cinema, $hall, $date);			
			}else{
				$sql = sprintf( "SELECT * FROM session WHERE 
							idcinema = '%s' AND idhall = '%s' AND date = '%s' AND start_time = '%s'", 
							$cinema, $hall, $date, $start);	
			}
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}
		
		
		public function getAllSessionsFromDateHallAndCinema($cinema, $hall, $date){
			$sql = sprintf( "SELECT * FROM session WHERE 
							idcinema = '%s' AND idhall = '%s' AND date = '%s'", 
							$cinema, $hall, $date);	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			
			$sessions = null;
			
			while($fila=mysqli_fetch_array($resul)){
				$sessions[] = $this->loadSession($fila["id"], $fila["idfilm"], $fila["idhall"], $fila["idcinema"], $fila["date"], $fila["start_time"], $fila["seat_price"], $fila["format"]);
			}
			
			mysqli_free_result($resul);
			
			return $sessions;
		}
		
		//Edit Session.
        public function editSession($id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format){

            $sql = sprintf( "UPDATE `session`
                             SET `idfilm` = '%d' , `idhall` = '%d', `idcinema` = '%d', `date` = '%s',
                                  `start_time` = '%s', `seat_price` = '%d', `format` = '%s'
                             WHERE `session`.`id` = '%d';", 
                $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, $id);

            $resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

            return $resul;
        }

        //Delete Session.
        public function deleteSession($id){

            $sql = sprintf( "DELETE FROM `session` WHERE `session`.`id` = '%d';",$id);

            $resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

            return $resul;
        }
		
		
		//Create a new Session Data Transfer Object.
		public function loadSession( $id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format){
			return new SessionDTO( $id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format);
		}

    }

?>
