<?php
    class UserDTO implements UsersDTO {

        //Attributes:
        private $_id;           //User Id.
        private $_username;     //User name.
        private $_email;        //User email.
        private $_password;     //User password.
        private $_rol;          //Type of user: user | manager | admin.

		//Constructor:
        function __construct($id, $username, $email, $password, $roles){
            $this->_id = $id;
            $this->_username = $username;
            $this->_email = $email;
            $this->_password = $password;
            $this->_rol = $roles;
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
        public function setRoles($rol){ $this->_rol = $rol; }
		public function getRoles(){ return $this->_rol; }

    }
?>