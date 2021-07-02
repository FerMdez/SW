<?php
   
    class Film{

        //Attributes:
        private $_id;               //Film ID.
        private $_tittle;           //Film tittle.
        private $_duration;         //Film duration.
        private $_language;         //Film language.
        private $_description;      //Film description.
        private $_img;              //Film image.

		//Constructor:
        function __construct($id, $tittle, $duration, $language, $description, $img){
            $this->_id = $id;
            $this->_tittle = $tittle;
            $this->_duration = $duration;
            $this->_language = $language;
            $this->_description = $description;
            $this->_img = $img;
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
        public function setImg($img){  $this->_img = $img;}
		public function getImg(){return   $this->_img;}
    }
?>