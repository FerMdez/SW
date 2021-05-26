<?php
	include_once($prefix.'assets/php/includes/seat_dao.php');

    class Seat{

        //Attributes:
        private $_idhall;     
        private $_idcinema;    
		private $_numRow;     
        private $_numCol;      
		private $_state;      

		//Constructor:
        function __construct($idhall, $idcinema, $numRow, $numCol, $state){
            $this->_number = $idhall;
            $this->_idcinema = $idcinema;
            $this->_numRow = $numRow;
			$this->_numCol = $numCol;
			$this->_state = $state;
        }
		
		static public function createSeats($hall, $cinema, $rows, $cols, $seats_map){
			$bd = new SeatDAO('complucine');

			for($i = 1;$i <= $rows;$i++){
				for($j = 1; $j <= $cols;$j++){
					$bd->createSeat($hall, $cinema, $i, $j, $seats_map[$i][$j]);
				}
			}
		}
		
		static public function getSeatsMap($number, $cinema){
			$bd = new SeatDAO('complucine');
			if($bd )
				return $bd->getAllSeats($number, $cinema);
		}
		
		static public function deleteAllSeats($number, $cinema){
			$bd = new SeatDAO('complucine');
			if($bd)
				return $bd->deletemapSeats($number, $cinema);
		}

		//Getters && Setters:
        public function setNumber($number){	$this->_number = $number; }
		public function getNumber(){ return $this->_number; }

        public function setIdcinema($idcinema){	$this->_idcinema = $idcinema; }
		public function getIdcinema(){ return $this->_idcinema; }

		public function setNumRows($numRow){ $this->_numRow = $numRow; }
		public function getNumRows(){ return $this->_numRow; }
		
		public function setNumCol($numCol){ $this->_numCol = $numCol; }
		public function getNumCol(){ return $this->_numCol; }
		
		public function setState($state){ $this->_state = $state; }
		public function getState(){ return $this->_state; }



    }
?>