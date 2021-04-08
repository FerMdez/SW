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
		public function createSession($id, $idfilm, $idhall, $date, $startTime, $seatPrice, $format){

			$sql = sprintf( "INSERT INTO sessions( $id, $idfilm, $idhall, $date, $startTime, $seatPrice, $format) 
								VALUES ( '%s', '%s', '%s', '%date', '%time', '%d', '%s')", 
									 $id, $idfilm, $idhall, $date, $startTime, $seatPrice, $format );

			return $sql;
		}

		//Returns a query to get the session's data.
		public function sessionData($id){
			$sql = sprintf( "SELECT * FROM sessions WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Create a new Session Data Transfer Object.
		public function loadSession( $id, $idfilm, $idhall, $date, $startTime, $seatPrice, $format){
			return new SessionDTO( $id, $idfilm, $idhall, $date, $startTime, $seatPrice, $format);
		}

    }

?>