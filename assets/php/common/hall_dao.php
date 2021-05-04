<?php
	require_once($prefix.'assets/php/dao.php');
	include_once('hall.php');

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
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error BD createhall');
			
			return $sql;
		}
		
		//Returns a query to get the halls data.
		public function getAllHalls($cinema){
			$sql = sprintf( "SELECT * FROM hall WHERE 
							idcinema = '%s'", 
							$cinema);	
							
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			
			$hall = null;
			
			while($fila=mysqli_fetch_array($resul)){
				$hall[] = $this->loadHall($fila["number"], $fila["idcinema"], $fila["numrows"], $fila["numcolumns"]);
			}
			
			mysqli_free_result($resul);
			
			return $hall;
		}
		
		//Returns the count of the hall searched
		public function searchHall($number, $cinema){
			
			$sql = sprintf( "SELECT COUNT(*) FROM hall WHERE 
							idcinema = '%s' AND number = '%s'", 
							$cinema, $number);	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			
			$hall = mysqli_fetch_array($resul);
			
			mysqli_free_result($resul);
			
			return $hall[0];
		}
		
		
		
		//Create a new Hall Data Transfer Object.
		public function loadHall($number, $idcinema, $numrows, $numcolumns){
			return new Hall($number, $idcinema, $numrows, $numcolumns);
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