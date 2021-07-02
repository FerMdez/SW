<?php
	include_once('seat.php');
	
    class SeatDAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Seat  taking the new hall,cinema,row,col and state saving in the database
		public function createSeat($hall, $cinema, $row, $col, $state){

			$sql = sprintf( "INSERT INTO `seat`( `idhall`, `idcinema`, `numrow`, `numcolum`, `active`) 
								VALUES ( '%d', '%d', '%d', '%d', '%d')", 
								$hall, $cinema, $row, $col, $state);
	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error BD createSeat');
			
			return $sql;
		}
		
		//Returns a query to get all the seat's data.
		public function getAllSeats($number, $cinema){
			
			$sql = sprintf( "SELECT * FROM seat WHERE 
							idhall = '%d' AND idcinema = '%d'", 
							$number, $cinema);	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			
			$seat_map = null;
			while($fila=mysqli_fetch_array($resul)){
				$seat_map[] = $this->loadSeat($fila["idhall"], $fila["idcinema"], $fila["numrow"], $fila["numcolum"], $fila["active"]);
			}
			
			mysqli_free_result($resul);
			
			return $seat_map;
		}

		//Delete a Seat whit the primary key
		public function deletemapSeats($hall, $cinema){
            $sql = sprintf( "DELETE FROM `seat` WHERE 
							idcinema = '%s' AND idhall = '%s'", 
							$cinema, $hall);	

            $resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

            return $resul;
        }

		//Change state of the seat.
		/*
		public function changeSeatState($hall, $cinema, $row, $col, $state){
			$id = $this->mysqli->real_escape_string($idHall);
			$state = $this->mysqli->real_escape_string($state);

			$sql = sprintf( "UPDATE seat SET active = '%d' WHERE idhall = '%d' AND idcinema = '%d' AND numrow = '%d' AND numcolum = '%d'", 
																						$state, $hall, $cinema, $row, $col );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;

		}
		*/
		
		//Create a new Seat Data Transfer Object.
		public function loadSeat($idhall, $idcinema, $numRow, $numCol, $state){
			return new Seat($idhall, $idcinema, $numRow, $numCol, $state);
		}
		
    }

?>