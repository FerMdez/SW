<?php
    interface SessionsDTO {
        public function setId($id);
		public function getId();
        public function setIdfilm($idfilm);
		public function getIdfilm();
        public function setIdhall($film);
		public function getIdhall();
		public function setIdcinema($cinema);
		public function getIdcinema();
		public function setDate($date);
		public function getDate();
		public function setStartTime($startTime);
		public function getStartTime();
		public function setSeatPrice($seatPrice);
		public function getSeatPrice();
		public function setFormat($format);
		public function getFormat();
    }
?>