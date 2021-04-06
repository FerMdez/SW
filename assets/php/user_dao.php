<?php
	require_once('dao.php');
	include_once('user_dto.php');

    class UserDAO extends DAO {
		
		//Constants:
		private const _USER = "user";
		private const _MANAGER = "manager";
		private const _ADMIN = "admin";

        //Attributes:

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Encrypt password with SHA254
		private function encryptPass($password){
			$password = hash('sha256', $password);

			return $password;
		}

        //Create a new User:
		public function createUser($id, $username, $email, $password, $rol){
			$password = $this->encryptPass($password);
			$sql = sprintf( "INSERT INTO users( id, username, email, passwd, rol) 
								VALUES ( '%s', '%s', '%s', '%s', '%s')", 
									$id, $username, $email, $password, $rol );

			return $sql;

		}

		//Returns a query to check if the user name exists:
		public function selectUser($username){
			$sql = sprintf( "SELECT * FROM users WHERE username = '%s'", $username );

			//return $sql;
			return $result = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
		}

		//Returns a query to check if the user pass matches:
		public function selectPass($password){
			$sql = sprintf( "SELECT * FROM users WHERE passwd = '%s'", $password );

			//return $sql;
			return $result = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
		}

		//Returns a query to get the user's data:
		public function userData($id){
			$sql = sprintf( "SELECT * FROM users WHERE id = '%d'", $id );

			//return $sql;
			return $result = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
		}

		//Create a new User Data Transfer Object:
		public function loadUser($id, $username, $email, $password, $rol){
			return new UserDTO($id, $username, $email, $password, $rol);
		}

    }

?>