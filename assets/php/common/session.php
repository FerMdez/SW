<?php
    class Session{

        private $_id;          
        private $_idfilm;
        private $_idhall;
		private $_idcinema;			
        private $_date;
        private $_startTime;
        private $_seatPrice;
        private $_format;

        function __construct($id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format){
            $this->_id = $id;
            $this->_idfilm = $idfilm;
            $this->_idhall = $idhall;
			$this->_idcinema = $idcinema;
            $this->_date = $date;
            $this->_startTime = $startTime;
            $this->_seatPrice = $seatPrice;
            $this->_format = $format;
        }

        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }

        public function setIdfilm($idfilm){ $this->_idfilm = $idfilm; }
		public function getIdfilm(){ return $this->_idfilm; }
        
        public function setIdhall($idhall){ $this->_idhall = $idhall; }
		public function getIdhall(){ return $this->_idhall; }
		
		public function setIdcinema($cinema){ $this->_idcinema = $idcinema; }
		public function getIdcinema(){ return $this->_idcinema; }

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