<?php
	include_once('promotion.php');

    class Promotion_DAO extends DAO {

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

        //Create a new Session.
		public function createPromotion($id, $tittle, $description, $code, $active){
			$sql = sprintf( "INSERT INTO `promotion`( `id`, `tittle`, `description`, `code`, `active`) 
								VALUES ( '%d', '%s', '%s', '%s', '%s')", 
									$id, $tittle, $description, $code, $active);
			
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}
		
		
	    //Returns a query to get All the films.
		public function allPromotionData(){
			$sql = sprintf( "SELECT * FROM promotion ");
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			while($fila=$resul->fetch_assoc()){
				$promotions[] = $this->loadPromotion($fila["id"], $fila["tittle"], $fila["description"], $fila["code"], $fila["active"]);
			}
			$resul->free();
			return $promotions;
		}

		//Returns a  film data .
		public function GetPromotion($code){
			$sql = sprintf( "SELECT * FROM promotion WHERE promotion.code = '%s'", $code );
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}

		//Returns a  film data .
		public function promotionData($id){
			$sql = sprintf( "SELECT * FROM promotion WHERE promotion.id = '%d'", $id);
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');
			return $resul;
		}

		//Deleted film by "id".
		public function deletePromotion($id){
			$sql = sprintf( "DELETE FROM promotion WHERE promotion.id = '%d' ;",$id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
		
		//Edit a film.
		public function editPromotion($id, $tittle, $description, $code, $active){
			$sql = sprintf( "UPDATE promotion SET tittle = '%s' , description = '%s', code ='%s' , active ='%s'
								WHERE promotion.id = '%d';", 
									 $tittle, $description, $code, $active, $id);

			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			return $resul;
		}
	    
		//Create a new film Data Transfer Object.
		public function loadPromotion($id, $tittle, $description, $code, $active){
			return new Promotion($id, $tittle, $description, $code, $active);
		}
	    	
    }

?>
