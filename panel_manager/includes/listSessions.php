<?php

include_once('session_dao.php');


class ListSessions{
	
    //Atributes:
	private $array;
	private $size;

    //Constructor:
    public function __construct() {
        $this->array = array();
    }
    //Methods:

    //Returns the whole session array
    public function getArray() {
        return $this->array;
    }
	
	//Returns the value i from the array
    public function getiArray($i) {
		if($i < $size){
			return $this->array($i);
		} else {
			return null;
		}
		
    }

    //Update the array with new values
    public function filterList($cinema, $hall, $date) {

        $date = date('Y-m-d', strtotime( $date ) );
		
		$bd = new sessionDAO('complucine');
		
		if($bd){
			$selectSession = $bd->selectSession($cinema, $hall, null, $date);
			$selectSession->data_seek(0);
			$this->size = 0;
			while ($fila = $selectSession->fetch_assoc()) {
                $this->array[]= new SessionDTO($fila['id'], $fila['idfilm'], $fila['idhall'], $fila['idcinema'], $fila['date'], date('H:i', strtotime( $fila['start_time'])) , $fila['seat_price'], $fila['format']);
				$this->size++;
			}
			mysqli_free_result($selectSession);	
		}
    }

}

?>

