<?php
    
    class Manager{

        //Attributes:
        private $_id;               //Manager ID.
        private $_username;           //Manager username.
        private $_email;         //Email.
        private $_pass;         //Pass.
        private $_roll;       //Roll

		//Constructor:
        function __construct($id, $username, $email, $pass, $roll){
            $this->_id = $id;
            $this->_username = $username;
            $this->_email = $email;
            $this->_pass = $pass;
            $this->_roll = $roll;
        }

		//Methods:

		//Getters && Setters:
        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }
        public function setUsername($username){$this->_username = $username; }
		public function getUsername(){ return 	$this->_username = $username; }
        public function setEmail($email){$this->_email = $email;}
		public function getEmail(){return $this->_email = $email;}
        public function setPass($pass){$this->_pass = $pass;}
		public function getPass(){return  $this->pass;}
        public function setRoll($roll){$this->_roll = $roll;}
		public function getRoll(){return  $this->_roll = $roll;}

    }
?>