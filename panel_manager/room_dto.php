<?php
    class RoomDTO {

        //Attributes:
        private $_id;          //Room Id.
        private $_numCol;      //Num columns.
        private $_numRows;     //Num rows.


		//Constructor:
        function __construct($id, $numCol, $numRows){
            $this->_id = $id;
            $this->_numCol = $numCol;
            $this->_numRows = $numRows;
        }

		//Methods:

		//Getters && Setters:
        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }

		public function setNumCol($numCol){ $this->_numCol = $numCol; }
		public function getNumCol(){ return $this->_numCol; }

		public function setNumRows($numRows){ $this->_numRows = $numRows; }
		public function getNumRows(){ return $this->_numRows; }

    }
?>