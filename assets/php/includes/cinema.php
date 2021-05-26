<?php
    
    class Cinema{

        //Attributes:
        private $_id;               //Cinema ID.
        private $_name;           //Cinema name.
        private $_direction;         //Cinema direction.
        private $_phone;         //Cinema phone.
      

		//Constructor:
        function __construct($id, $name, $direction, $phone){
            $this->_id = $id;
            $this->_name = $name;
            $this->_direction = $direction;
            $this->_phone = $phone;
        }

		//Methods:

		//Getters && Setters:
        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }
        public function setName($name){	$this->_name = $name; }
		public function getName(){ return $this->_name; }
        public function setDirection($direction){ $this->_direction = $direction; }
		public function getDirection(){ return $this->_direction; }
        public function setPhone($phone){$this->_phone = $phone; }
		public function getPhone(){ return $this->_phone; }
    }
?>