<?php
	include_once('purchase.php');

    class PurchaseDAO extends DAO {

        //Attributes:

		//Constructor:
        function __construct($bd_name){
			parent::__construct($bd_name);
        }

		//Methods:

		//Create a new Purchase.
		public function createPurchase($idUser, $idSession, $idHall, $idCinema, $row, $column, $time){
			$sql = sprintf( "INSERT INTO purchase( iduser, idsession, idhall, idcinema, numrow, numcolum, time_purchase ) 
								VALUES ( '%d', '%d', '%d', '%d', '%d', '%d', '%s' )", 
									$idUser, $idSession, $idHall, $idCinema, $row, $column, $time );
			
			$resul = mysqli_query($this->mysqli, $sql);

			return $resul;
		}

		//All purchases of one user.
		public function allPurchasesData($idUser){
			$sql = sprintf( "SELECT * FROM purchase WHERE iduser = '%d' ", $idUser);
			$resul = mysqli_query($this->mysqli, $sql) or die ('Error into query database');

			$purchases = null;
			while($fila=$resul->fetch_assoc()){
				$purchases[] = $this->loadPurchase($fila["iduser"], $fila["idsession"], $fila["idhall"], $fila["idcinema"], $fila["numrow"], $fila["numcolum"], $fila["time_purchase"]);
			}
			$resul->free();
			return $purchases;
		}

		//Create a new User Data Transfer Object.
		public function loadPurchase($idUser, $idSession, $idHall, $idCinema, $row, $column, $time){
			return new Purchase($idUser, $idSession, $idHall, $idCinema, $row, $column, $time);
		}

    }

?>