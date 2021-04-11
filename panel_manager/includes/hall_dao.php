<?php
	require_once('../assets/php/dao.php');
	include_once('hall_dto.php');

    class HallDAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Hall.
		public function createHall($number, $idcinema, $numCol, $numRows){

			$sql = sprintf( "INSERT INTO `hall`( `number`, `idcinema`, `numrows`, `numcolumns`) 
								VALUES ( '%d', '%d', '%i', '%i')", 
								$number, $idcinema, $numRows, $numCol );

			return $sql;
		}

		//Returns a query to get the halls data.
		public function hallData($id,$idcinema){
			$sql = sprintf( "SELECT * FROM `hall` 
							WHERE `hall`.`number` = '%d' AND `hall`.`idcinema` = '%d';", 
							$id, $idcinema );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Create a new Hall Data Transfer Object.
		public function loadHall($id, $idcinema, $numCol, $numRows){
			return new HallDTO($id, $idcinema, $numCol, $numRows);
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