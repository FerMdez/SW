<?php
	require_once('../assets/php/dao.php');
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

        //Encrypt password with SHA254.
		private function encryptPass($password){
			//$password = hash('sha256', $password);
			$password = password_hash($password, PASSWORD_DEFAULT);

			return $password;
		}

		//Returns true if the password and hash match, or false otherwise.
		public function verifyPass($password, $passwd){
			return password_verify($password, $passwd);
		}

        //Create a new User.
		public function createUser($id, $username, $email, $password, $rol){
			$password = $this->encryptPass($password);

			$sql = sprintf( "INSERT INTO users( id, username, email, passwd, rol) 
								VALUES ( '%s', '%s', '%s', '%s', '%s')", 
									$id, $username, $email, $password, $rol );
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Returns a query to check if the user name exists.
		public function selectUser($username){
			$username = $this->mysqli->real_escape_string($username);

			$sql = sprintf( "SELECT * FROM users WHERE username = '%s'", $username );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Returns a query to check if the user pass matches.
		public function selectPass($username, $password){
			$username = $this->mysqli->real_escape_string($username);
			$password = $this->mysqli->real_escape_string($password);
			$password = $this->encryptPass($password);

			$sql = sprintf( "SELECT * FROM users WHERE username = '%s' AND passwd = '%s'", $username, $password);
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			//return $this->mysqli->query($sql);
			return $resul;
		}

		//Returns a query to get the user's data.
		public function userData($id){
			$sql = sprintf( "SELECT * FROM users WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Create a new User Data Transfer Object.
		public function loadUser($id, $username, $email, $password, $rol){
			return new UserDTO($id, $username, $email, $password, $rol);
		}

    }

?>
