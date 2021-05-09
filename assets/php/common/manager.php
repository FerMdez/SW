<?php
    
    class Manager{

        //Attributes:
        private $_id;               //Manager ID.
        private $_username;           //Manager username.
        private $_email;         //Email.
        private $_roll;       //Roll

		//Constructor:
        function __construct($id, $idcinema, $username, $email, $roll){
            $this->_id = $id;
            $this->_idcinema = $idcinema;
            $this->_username = $username;
            $this->_email = $email;
            $this->_roll = $roll;
        }
	
		//Methods:
	    
		//Getters && Setters:
        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }
        public function setIdcinema($idcinema){	$this->_idcinema = $idcinema; }
		public function getIdcinema(){ return $this->_idcinema; }
        public function setUsername($username){$this->_username = $username; }
		public function getUsername(){ return 	$this->_username;}
        public function setEmail($email){$this->_email = $email;}
		public function getEmail(){return $this->_email;}
        public function setRoll($roll){$this->_roll = $roll;}
		public function getRoll(){return  $this->_roll;}

    }
?>
