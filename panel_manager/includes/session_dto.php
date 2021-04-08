<?php
    include_once('session_dto_interface.php');

    class SessionDTO  implements SessionsDTO {

        //Attributes:
        private $_id;           //Session Id.
        private $_idfilm;       //Film Id
        private $_idhall        //Hall id
        private $_date;         //Session date.
        private $_startTime;    //Session start time.
        private $_seatPrice;    //Seat price.
        private $_format;       //Type of film: 3D | 4D | normal | subtitle | mute.

		//Constructor:
        function __construct($id, $idfilm, $idhall, $date, $startTime, $seatPrice, $format){
            $this->_id = $id;
            $this->_idfilm = $idfilm;
            $this->_idhall = $idhall;
            $this->_date = $date;
            $this->_startTime = $startTime;
            $this->_seatPrice = $seatPrice;
            $this->_format = $format;
        }

		//Methods:

		//Getters && Setters:
        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }

        public function setIdfilm($idfilm){ $this->_idfilm = $idfilm; }
		public function getIdfilm(){ return $this->_idfilm; }
        
        public function setIdhall($film){ $this->_idhall = $idhall; }
		public function getIdhall(){ return $this->_idhall; }

		public function setDate($date){ $this->_date = $date; }
		public function getDate(){ return $this->_date; }

		public function setStartTime($startTime){ $this->_startTime = $startTime; }
		public function getStartTime(){ return $this->_startTime; }

		public function setSeatPrice($seatPrice){ $this->_seatPrice = $seatPrice; }
		public function getSeatPrice(){ return $this->_seatPrice; }

		public function setFormat($format){ $this->_format = $format; }
		public function getFormat(){ return $this->_format; }

    }
?>