<?php
	include_once('manager.php');
	$template = new Template();
    $prefix = $template->get_prefix();
	include_once($prefix.'assets/php/dao.php');

    class Manager_DAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new user Manager.
		public function createManager($id, $username, $email, $pass, $rol){
			$password = $this->encryptPass($pass);
			$sql = sprintf( "INSERT INTO `users`( `id`, `username`, `email`, `passwd`, `rol`) 
								VALUES ( '%d', '%s', '%s', '%s', '%s')", 
									$id, $username, $email, $password, $rol);
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}
		
		private function encryptPass($password){
			//$password = hash('sha256', $password);
			$password = password_hash($password, PASSWORD_DEFAULT);

			return $password;
		}

		
	    //Returns a query to get All the managers.
		public function allManagersData(){
			$sql = sprintf( "SELECT * FROM users WHERE users.rol=manager");
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			while($fila=$resul->fetch_assoc()){
				$managers[] = $this->loadManager($fila["id"], $fila["username"], $fila["email"], $fila["password"], $fila["rol"]);
			}
			$resul->free();
			return $managers;
		}

		//Returns a  manager data .
		public function GetManager($id){
			$sql = sprintf( "SELECT * FROM users WHERE users.id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}
          
        public function selectManager($username){
			$username = $this->mysqli->real_escape_string($username);

			$sql = sprintf( "SELECT * FROM users WHERE username = '%s'", $username );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			$resul->data_seek(0);
			while ($fila = $resul->fetch_assoc()) {
                $user = $this->loadUser($fila['id'], $fila['username'], $fila['email'], $fila['passwd'], $fila['rol']);
			}

			//mysqli_free_result($selectUser);
			$resul->free();

			return $user;
		} 
	

		//Deleted manager by "id".
		public function deleteManager($id){
			$sql = sprintf( "DELETE FROM users WHERE users.id = '%d' ;",$id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
		
		//Edit manager.
		public function editManager($id, $username, $email, $pass, $rol){
			$password = $this->encryptPass($pass);
			$sql = sprintf( "UPDATE users SET email = '%s' , passwd = '%s',
								WHERE users.id = '%d';", 
									 $email, $password, $id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
	    
		//Create a new Manager Data Transfer Object.
		public function loadManager($id, $username, $email, $pass, $rol){
			return new Manager($id, $username, $email, $pass, $rol);
		}
	    	
    }

?>
