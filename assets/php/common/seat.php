<?php
	include_once($prefix.'assets/php/common/seat_dao.php');

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
		
		static public function createSeats($seat){
			$bd = new SeatDAO('complucine');

			for($i = 1;$i <= $seat["rows"];$i++){
				for($j = 1; $j <= $seat["cols"];$j++){
					error_log("DAO ===>  number ->".$seat['number']." cinema ->".$seat['cinema']." fila -> ". $i. " columna ->".$j." activa -> ".$seat[$i][$j]);
					if($seat[$i][$j] == "1"){
						$bd->createSeat($seat, $i, $j);
					}
				}
			}
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