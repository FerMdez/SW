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
			$sql = sprintf( "SELECT * FROM sessions WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

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
		
		
		
		
		//Create a new Session Data Transfer Object.
		public function loadSession( $id, $idfilm, $idhall, $date, $startTime, $seatPrice, $format){
			return new SessionDTO( $id, $idfilm, $idhall, $date, $startTime, $seatPrice, $format);
		}

    }

?>
