<?php
	require_once($prefix.'assets/php/dao.php');
	include_once('hall.php');
	include_once('seat_dao.php');
	
    class HallDAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Hall.
		public function createHall($hall){
			
			$sql = sprintf( "INSERT INTO `hall`( `number`, `idcinema`, `numrows`, `numcolumns`, `total_seats`) 
								VALUES ( '%d', '%d', '%d', '%d', '%d')", 
								$hall['number'], $hall['cinema'], $hall['rows'], $hall['cols'], $hall['seats'] );
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error BD createhall');
			
			Seat::createSeats($hall);
			
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
				$hall[] = $this->loadHall($fila["number"], $fila["idcinema"], $fila["numrows"], $fila["numcolumns"], $fila["total_seats"]);
			}
			
			mysqli_free_result($resul);
			
			return $hall;
		}
		
		//Returns the count of the hall searched
		public function searchHall($hall){
			
			$sql = sprintf( "SELECT COUNT(*) FROM hall WHERE 
							idcinema = '%s' AND number = '%s'", 
							$hall['cinema'], $hall['number']);	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			
			$hall = mysqli_fetch_array($resul);
			
			mysqli_free_result($resul);
			
			return $hall[0];
		}
		
		
		
		//Create a new Hall Data Transfer Object.
		public function loadHall($number, $idcinema, $numrows, $numcolumns,$total_seats){
			return new Hall($number, $idcinema, $numrows, $numcolumns,$total_seats);
		}

		//Edit Hall.
		public function editHall($hall){

			$sql = sprintf( "UPDATE `hall`
							SET `numrows` = '%d' , `numcolumns` = '%d' , `total_seats` = %d
							WHERE `hall`.`number` = '%d' AND `hall`.`idcinema` = '%d';", 
							$hall['rows'], $hall['cols'], $hall['seats'], $hall['number'], $hall['cinema'] );

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Delete Hall.
		public function deleteHall($hall){

			$sql = sprintf( "DELETE FROM `hall` WHERE `hall`.`number` = '%d' AND `hall`.`idcinema` = '%d';",$hall['number'], $hall['cinema']);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

    }

?>