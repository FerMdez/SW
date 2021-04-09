<?php
    include_once('film_dto_interface.php');
    
    class FilmDTO implements FilmDTOs {

        //Attributes:
        private $_id;           //User Id.
        private $_tittle;     //User name.
        private $_duration;        //User email.
        private $_language;     //User password.
      

		//Constructor:
        function __construct($id, $tittle, $duration, $language){
            $this->_id = $id;
            $this->_tittle = $tittle;
            $this->_duration = $duration;
            $this->_language = $language;
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
    }
?>