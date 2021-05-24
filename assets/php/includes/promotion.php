<?php
    
    class Promotion{

        //Attributes:
        private $_id;               //Promotion ID.
        private $_tittle;           //Promotions name.
        private $_description;      //Promotion description.
        private $_code;             //Promotion code.
        private $_active;           //Promotion is active?

		//Constructor:
        function __construct($id, $tittle, $description, $code, $active){
            $this->_id = $id;
            $this->_tittle = $tittle;
            $this->_description = $description;
            $this->_code = $code;
            $this->_active = $active;
        }

		//Methods:

		//Getters && Setters:
        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }
        public function setTittle($tittle){	$this->_tittle = $tittle; }
		public function getTittle(){ return $this->_tittle; }
        public function setDescription($description){  $this->_description = $description;}
		public function getDescription(){return  $this->_description;}
        public function setCode($code){  $this->_code = $code;}
		public function getCode(){return  $this->_code;}
        public function setActive($active){  $this->_active = $active;}
		public function getActive(){return  $this->_active;}

    }
?>