<?php
    include_once('hall_dto_interface.php');

    class HallDTO implements HallsDTO {

        //Attributes:
        private $_number;      //Room number.
        private $_idcinema;    //Cinema Id
        private $_numCol;      //Num columns.
        private $_numRows;     //Num rows.


		//Constructor:
        function __construct($number, $idcinema, $numCol, $numRows){
            $this->_number = $number;
            $this->_idcinema = $idcinema;
            $this->_numCol = $numCol;
            $this->_numRows = $numRows;
        }

		//Methods:

		//Getters && Setters:
        public function setNumber($number){	$this->_number = $number; }
		public function getNumber(){ return $this->_number; }

        public function setIdcinema($idcinema){	$this->_idcinema = $idcinema; }
		public function getIdcinema(){ return $this->_idcinema; }

		public function setNumCol($numCol){ $this->_numCol = $numCol; }
		public function getNumCol(){ return $this->_numCol; }

		public function setNumRows($numRows){ $this->_numRows = $numRows; }
		public function getNumRows(){ return $this->_numRows; }

    }
?>