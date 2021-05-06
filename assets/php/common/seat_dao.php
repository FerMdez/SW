<?php
	require_once($prefix.'assets/php/dao.php');
	include_once('seat.php');
	
    class SeatDAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Hall.
		public function createSeat($seat, $row, $col){

			$sql = sprintf( "INSERT INTO `seat`( `idhall`, `idcinema`, `numrow`, `numcolum`, `active`) 
								VALUES ( '%d', '%d', '%d', '%d', '%d')", 
								$seat['number'], $seat['cinema'], $row, $col, $seat[$row][$col]);
	
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error BD createSeat');
			
			return $sql;
		}
    }

?>