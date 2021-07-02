<?php
	include_once('user.php');

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


		//All users
		public function allUsersNotM(){
			$sql = sprintf( "SELECT * FROM `users` WHERE users.id NOT IN (SELECT id FROM `manager`)");
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			while($fila=$resul->fetch_assoc()){
				$users[] = $this->loadUser($fila['id'], $fila['username'], $fila['email'], $fila['passwd'], $fila['rol']);
			}
			$resul->free();
			return $users;
		}

        //Create a new User.
		public function createUser($id, $username, $email, $password, $rol){
			$password = $this->encryptPass($password);

			$sql = sprintf( "INSERT INTO users( id, username, email, passwd, rol) 
								VALUES ( '%s', '%s', '%s', '%s', '%s')", 
									$id, $username, $email, $password, $rol );
			
			$resul = mysqli_query($this->mysqli, $sql);

			return $resul;
		}

		//Returns a query to check if the user name exists.
		public function selectUser($username, $password){
			$username = $this->mysqli->real_escape_string($username);
			$password = $this->mysqli->real_escape_string($password);

			$sql = sprintf( "SELECT * FROM users WHERE username = '%s'", $username );
			$resul = mysqli_query($this->mysqli, $sql);

			$resul->data_seek(0);
			$user = null;
			while ($fila = $resul->fetch_assoc()) {
				if($username === $fila['username'] && $this->verifyPass($password, $fila['passwd'])){
					$user = $this->loadUser($fila['id'], $fila['username'], $fila['email'], $fila['passwd'], $fila['rol']);
				}
			}

			//mysqli_free_result($selectUser);
			$resul->free();

			return $user;
		}

		//Returns a query to get the user's data.
		public function userData($id){
			$id = $this->mysqli->real_escape_string($id);
			
			$sql = sprintf( "SELECT * FROM users WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Search a user by name.
		public function selectUserName($username){
			$username = $this->mysqli->real_escape_string($username);

			$sql = sprintf( "SELECT * FROM users WHERE username = '%s'", $username );
			$resul = mysqli_query($this->mysqli, $sql);

			return $resul;
		}

		//Search a user by email.
		public function selectUserEmail($email){
			$email = $this->mysqli->real_escape_string($email);

			$sql = sprintf( "SELECT * FROM users WHERE email = '%s'", $email );
			$resul = mysqli_query($this->mysqli, $sql);

			return $resul;
		}

		//Change username by id.
		public function changeUserName($id, $username){
			$id = $this->mysqli->real_escape_string($id);
			$username = $this->mysqli->real_escape_string($username);

			$sql = sprintf( "UPDATE users SET username = '%s' WHERE id = '%d'", $username, $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;

		}

		//Change userpass by id.
		public function changeUserPass($id, $password){
			$id = $this->mysqli->real_escape_string($id);
			$password = $this->mysqli->real_escape_string($password);
			$password = $this->encryptPass($password);

			$sql = sprintf( "UPDATE users SET passwd = '%s' WHERE id = '%d'", $password, $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;

		}

		//Change user email by id.
		public function changeUserEmail($id, $email){
			$id = $this->mysqli->real_escape_string($id);
			$email = $this->mysqli->real_escape_string($email);

			$sql = sprintf( "UPDATE users SET email = '%s' WHERE id = '%d'", $email, $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;

		}

		//Delete user account by id.
		public function deleteUserAccount($id){
			$id = $this->mysqli->real_escape_string($id);

			$sql = sprintf( "DELETE FROM users WHERE id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}

		//Create a new User Data Transfer Object.
		public function loadUser($id, $username, $email, $password, $rol){
			return new User($id, $username, $email, $password, $rol);
		}

    }

?>