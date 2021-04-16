<?php
    class SessionDTO  {

        //Attributes:
        private $_id;           //Session Id.
        private $_date;         //Session date.
        private $_startTime;    //Session start time.
        private $_seatPrice;    //Seat price.
        private $_format;       //Type of film: 3D | 4D | normal | subtitle | mute.
        private $_film;         //Object film, ESTO HAY QUE CAMBIARLO? POR UN OBJETO TIPO PELICULA

		//Constructor:
        function __construct($id, $date, $startTime, $seatPrice, $format, $film){
            $this->_id = $id;
            $this->_date = $date;
            $this->_startTime = $startTime;
            $this->_seatPrice = $seatPrice;
            $this->_format = $format;
            $this->_film = $film;
        }

		//Methods:

		//Getters && Setters:
        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }

		public function setDate($date){ $this->_date = $date; }
		public function getDate(){ return $this->_date; }

		public function setStartTime($startTime){ $this->_startTime = $startTime; }
		public function getStartTime(){ return $this->_startTime; }

		public function setSeatPrice($seatPrice){ $this->_seatPrice = $seatPrice; }
		public function getSeatPrice(){ return $this->_seatPrice; }

		public function setFormat($format){ $this->_format = $format; }
		public function getFormat(){ return $this->_format; }

		public function setFilm($film){ $this->_film = $film; }
		public function getFilm(){ return $this->_film; }

    }
?>