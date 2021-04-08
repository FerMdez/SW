<?php
    interface UsersInterface {
        public function setId($id);
	public function getId();
	public function setName($username);
	public function getName();
        public function setEmail($email);
	public function getEmail();
	public function setPass($passwd);
	public function getPass();
        public function setRol($rol);
	public function getRol();
    }
?>
