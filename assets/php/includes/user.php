<?php   
    class User {

        //Attributes:
        private $_id;           //User Id.
        private $_username;     //User name.
        private $_email;        //User email.
        private $_password;     //User password.
        private $_rol;          //Type of user: user | manager | admin. --> Será eliminado en la siguiente práctica para usar el modelo relacional de nuestra BD.

		//Constructor:
        function __construct($id, $username, $email, $password, $rol){
            $this->_id = $id;
            $this->_username = $username;
            $this->_email = $email;
            $this->_password = $password;
            $this->_rol = $rol;
        }
        
		//Methods:

		//Getters && Setters:
        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }
		public function setName($username){ $this->_username = $username; }
		public function getName(){ return $this->_username; }
        public function setEmail($email){ $this->_email = $email; }
		public function getEmail(){ return $this->_email; }
		public function setPass($passwd){	$this->_password = $passwd; }
		public function getPass(){ return $this->_password; }
        public function setRol($rol){ $this->_rol = $rol; }
		public function getRol(){ return $this->_rol; }

    }
?>