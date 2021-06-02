<?php
	include_once('seat.php');
	
    class SeatDAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Hall.
		public function createSeat($hall, $cinema, $row, $col, $state){

			$sql = sprintf( "INSERT INTO `seat`( `idhall`, `idcinema`, `numrow`, `numcolum`, `active`) 
								VALUES ( '%d', '%d', '%d', '%d', '%d')", 
								$hall, $cinema, $row, $col, $state);
	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error BD createSeat');
			
			return $sql;
		}
		
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
		
		public function deletemapSeats($hall, $cinema){
            $sql = sprintf( "DELETE FROM `seat` WHERE 
							idcinema = '%s' AND idhall = '%s'", 
							$cinema, $hall);	

            $resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

            return $resul;
        }
			
		public function loadSeat($idhall, $idcinema, $numRow, $numCol, $state){
			return new Seat($idhall, $idcinema, $numRow, $numCol, $state);
		}
		
    }

?>