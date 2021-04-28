<?php
    include_once('film_dto_interface.php');
    
    class Film_DTO implements FilmDTO {

        //Attributes:
        private $_id;               //Film ID.
        private $_tittle;           //Film tittle.
        private $_duration;         //Film duration.
        private $_language;         //Film language.
        private $_description;      //Film description.
      

		//Constructor:
        function __construct($id, $tittle, $duration, $language, $description){
            $this->_id = $id;
            $this->_tittle = $tittle;
            $this->_duration = $duration;
            $this->_language = $language;
            $this->_description = $description;
        }

		//Methods:

		//Getters && Setters:
        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }
        public function setTittle($tittle) {$this->_tittle = $tittle; }
		public function getTittle(){return $this->_tittle;}
        public function setDuration($duration){$this->_duration = $duration; }
		public function getDuration() {return $this->_duration;}
        public function setLanguage($language) {$this->_language = $language; }
		public function getLanguage(){return $this->_language;}
        public function setDescription($description){  $this->_description = $description;}
		public function getDescription(){return  $this->_description;}
    }
?>