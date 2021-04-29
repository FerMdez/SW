<?php
    class Hall{

        //Attributes:
        private $_number;      //Room number.
        private $_idcinema;    //Cinema Id
		private $_numRows;     //Num rows.
        private $_numCol;      //Num columns.

		//Constructor:
        function __construct($number, $idcinema, $numRows, $numCol){
            $this->_number = $number;
            $this->_idcinema = $idcinema;
            $this->_numRows = $numRows;
			$this->_numCol = $numCol;
        }

		//Methods:

		//Getters && Setters:
        public function setNumber($number){	$this->_number = $number; }
		public function getNumber(){ return $this->_number; }

        public function setIdcinema($idcinema){	$this->_idcinema = $idcinema; }
		public function getIdcinema(){ return $this->_idcinema; }

		public function setNumRows($numRows){ $this->_numRows = $numRows; }
		public function getNumRows(){ return $this->_numRows; }
		
		public function setNumCol($numCol){ $this->_numCol = $numCol; }
		public function getNumCol(){ return $this->_numCol; }



    }
?>