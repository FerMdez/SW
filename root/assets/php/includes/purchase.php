<?php   
    class Purchase {

        //Attributes:
        private $_idUser;           //User Id.
        private $_idSession;        //Session Id.
        private $_idHall;           //Hall Id.
        private $_idCinema;         //Cinema Id.
        private $_numRow;           //Number of row seat.
        private $_numColumn;        //Number of column seat.
        private $_timePurchase;     //Time of purchase.

		//Constructor:
        function __construct($idUser, $idSession, $idHall, $idCinema, $row, $column, $time){
            $this->_idUser = $idUser;
            $this->_idSession = $idSession;
            $this->_idHall = $idHall;
            $this->_idCinema = $idCinema;
            $this->_numRow = $row;
            $this->_numColumn = $column;
            $this->_timePurchase = $time;
        }
        
		//Methods:

		//Getters && Setters:
        public function setUserId($idUser){	$this->_idUser = $id; }
		public function getUserId(){ return $this->_idUser; }
        public function setSessionId($idSession){	$this->_idSession = $idSession; }
		public function getSessionId(){ return $this->_idSession; }
        public function setHallId($idHall){	$this->_idHall = $idHall; }
		public function getHallId(){ return $this->_idHall; }
        public function setCinemaId($idCinema){	$this->_idCinema = $idCinema; }
		public function getCinemaId(){ return $this->_idCinema; }
        public function setRow($row){	$this->_numRow = $row; }
		public function getRow(){ return $this->_numRow; }
        public function setColumn($column){	$this->_numColumn = $column; }
		public function getColumn(){ return $this->_numColumn; }
        public function setTime($time){	$this->_timePurchase = $time; }
		public function getTime(){ return $this->_timePurchase; }

    }
?>