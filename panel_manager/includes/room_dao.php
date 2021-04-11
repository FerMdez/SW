<?php
	require_once('../assets/php/dao.php');
	include_once('room_dto.php');

    class RoomDAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Room.
		public function createRoom($id, $idcinema, $numCol, $numRows){

			$sql = sprintf( "INSERT INTO rooms( id, idcinema, numCol, numRows) 
								VALUES ( '%d', '%d', '%i', '%i')", 
									$id, $idcinema, $numCol, $numRows );

			return $sql;
		}

		//Returns a query to get the room's data.
		public function roomData($id){
			$sql = sprintf( "SELECT * FROM rooms WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Create a new Room Data Transfer Object.
		public function loadRoom($id, $idcinema, $numCol, $numRows){
			return new RoomDTO($id, $idcinema, $numCol, $numRows);
		}

		//Edit Hall.
		public function editHall($id, $idcinema, $numCol, $numRows){

			$sql = sprintf( "UPDATE `hall`
							SET `numrows` = '%i' , `numcolumns` = '%i'
							WHERE `hall`.`number` = '%d' AND `hall`.`idcinema` = '%d';", 
							$numRows,$numCol,$id, $idcinema );

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Delete Hall.
		public function deleteHall($id, $idcinema){

			$sql = sprintf( "DELETE FROM `hall` WHERE `hall`.`number` = '%d' AND `hall`.`idcinema` = '%d';",$id,$idcinema);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

    }

?>