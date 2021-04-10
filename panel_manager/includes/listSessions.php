<?php

include_once('session_dao.php');


class ListSessions{
	
    //Atributes:
	private $array;
	private $size;
	
	private $cinema;
	private $hall;
	private $date;

    //Constructor:
    public function __construct($cinema,$hall,$date) {
        $this->array = array();
		
		$this->cinema = $cinema;
		$this->hall = $hall;
		$this->date = $date;
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
	//Change the patterns of the filter
	public function setCinema($cinema){$this->cinema = $cinema;}
	public function setHall($hall){$this->hall = $hall;}
	public function setDate($date){$this->date = $date;}
	
    //Update the array with current filter values
    public function filterList() {
		
        $this->date = date('Y-m-d', strtotime( $this->date ) );
		
		$bd = new sessionDAO('complucine');
		
		if($bd){
			$selectSession = $bd->selectSession($this->cinema, $this->hall, null, $this->date);
			$selectSession->data_seek(0);
			$this->size = 0;
			while ($fila = $selectSession->fetch_assoc()) {
                $this->array[]= new SessionDTO($fila['id'], $fila['idfilm'], $fila['idhall'], $fila['idcinema'], $fila['date'], date('h:i', strtotime( $fila['start_time'])) , $fila['seat_price'], $fila['format']);
				$this->size++;
			}
			mysqli_free_result($selectSession);	
		}
    }

}

?>

