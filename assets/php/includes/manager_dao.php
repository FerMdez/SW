<?php
	include_once('manager.php');

    class Manager_DAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:
		
	   	//Returns a query to get all the manager's data.
		public function allManagersData(){
			$sql = sprintf( "SELECT * FROM `users` JOIN `manager` ON manager.id = users.id");
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			while($fila=$resul->fetch_assoc()){
				$managers[] = $this->loadManager($fila["id"], $fila["idcinema"], $fila["username"], $fila["email"], $fila["rol"]);
			}
			$resul->free();
			return $managers;
		}

		//Returns a  manager data taking the id
		public function GetManager($id){
			$sql = sprintf( "SELECT * FROM `manager` WHERE manager.id = '%d'", $id );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}

		//Returns a  manager data 
		public function GetManagerCinema($id, $idcinema){
			$sql = sprintf( "SELECT * FROM `manager` WHERE manager.id = '%d' AND manager.idcinema ='%d'", $id, $idcinema );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}

		 //Create a new Manager with a new id and id cinema
		 public function createManager($id, $idcinema){
			$sql = sprintf( "INSERT INTO `manager`( `id`, `idcinema`)
								VALUES ( '%d', '%d')", 
									$id, $idcinema);
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}
	

		//Deleted manager by "id".
		public function deleteManager($id){
			$sql = sprintf( "DELETE FROM `manager` WHERE manager.id = '%d' ;",$id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
		
		//Edit manager by "id" and "idcinema"
		public function editManager($id, $idcinema){
			$sql = sprintf( "UPDATE `manager` SET manager.idcinema = '%d'
								WHERE manager.id = '%d';", 
									 $idcinema, $id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
	    
		//Create a new Manager Data Transfer Object.
		public function loadManager($id, $idcinema, $username, $email, $rol){
			return new Manager($id, $idcinema, $username, $email, $rol);
		}
	    	
    }

?>
