<?php
	include_once('hall.php');
	
	
    class HallDAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new hall taking the new number,cinema, rows, cols, seats and seats map saving in the database
		public function createHall($number, $cinema, $rows, $cols, $seats, $seats_map){
			
			$sql = sprintf( "INSERT INTO `hall`( `number`, `idcinema`, `numrows`, `numcolumns`, `total_seats`) 
								VALUES ( '%d', '%d', '%d', '%d', '%d')", 
								$number, $cinema, $rows, $cols, $seats );
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error BD createhall');
			
			return $sql;
		}

		//Returns the hall's data by ID.
		public function HallData($id){
			$id = $this->mysqli->real_escape_string($id);

			$sql = sprintf( "SELECT * FROM hall WHERE number = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			$resul->data_seek(0);
			$hall = null;
			while ($fila = $resul->fetch_assoc()) {
				$hall = $this->loadHall($fila["number"], $fila["idcinema"], $fila["numrows"], $fila["numcolumns"], $fila["total_seats"], null);
			}

			//mysqli_free_result($selectUser);
			$resul->free();

			return $hall;
		}
		
		//Returns a query to get the halls data.
		public function getAllHalls($cinema){
			$sql = sprintf( "SELECT * FROM hall WHERE 
							idcinema = '%s'", 
							$cinema);	
							
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			
			$hall = null;
			while($fila=mysqli_fetch_array($resul)){
				$hall[] = $this->loadHall($fila["number"], $fila["idcinema"], $fila["numrows"], $fila["numcolumns"], $fila["total_seats"], null);
			}
			
			mysqli_free_result($resul);
			
			return $hall;
		}
		
		//Returns a  hall data taking the number and cinema
		public function searchHall($number, $cinema){
			
			$sql = sprintf( "SELECT * FROM hall WHERE 
							number = '%s' AND idcinema = '%s'", 
							$number, $cinema);	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			$hall = false;
			
			if($resul){
				if($resul->num_rows == 1){
					$fila = $resul->fetch_assoc();
					$hall = $this->loadHall($fila["number"], $fila["idcinema"], $fila["numrows"], $fila["numcolumns"], $fila["total_seats"], null);
				}
				$resul->free();
			}
		
			return $hall;
		}
		
		
		
		//Create a new Hall Data Transfer Object.
		public function loadHall($number, $idcinema, $numrows, $numcolumns, $total_seats, $seats_map){
			return new Hall($number, $idcinema, $numrows, $numcolumns, $total_seats, $seats_map);
		}

		//Edit a hall taking the new number, rows, cols ans seats with respect to its origin parameter
		public function editHall($number, $cinema, $rows, $cols, $seats, $og_number){
			
			$sql = sprintf( "UPDATE `hall`
							SET `number` = '%d' ,`numrows` = '%d' , `numcolumns` = '%d' , `total_seats` = %d
							WHERE `hall`.`number` = '%d' AND `hall`.`idcinema` = '%d';", 
							$number, $rows, $cols, $seats, $og_number, $cinema );
			
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Delete a hall whit the primary key
		public function deleteHall($number, $cinema){

			$sql = sprintf( "DELETE FROM `hall` WHERE `hall`.`number` = '%d' AND `hall`.`idcinema` = '%d';",$number, $cinema);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

    }

?>