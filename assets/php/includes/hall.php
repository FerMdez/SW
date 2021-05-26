<?php
	include_once('hall_dao.php');
	include_once('seat_dao.php');
	
    class Hall{

        //Attributes:
        private $_number;      //Room number.
        private $_idcinema;    //Cinema Id
		private $_numRows;     //Num rows.
        private $_numCol;      //Num columns.
		private $_total_seats;
		private $_seats_map;

		//Constructor:
        function __construct($number, $idcinema, $numRows, $numCol, $total_seats, $seats_map){
            $this->_number = $number;
            $this->_idcinema = $idcinema;
            $this->_numRows = $numRows;
			$this->_numCol = $numCol;
			$this->_total_seats = $total_seats;
			$_seats_map = array();
			$_seats_map = $seats_map;
        }

		//Methods:
		public static function getListHalls($cinema){
			$bd = new HallDAO('complucine');
			if($bd )
				return $bd->getAllHalls($cinema);
		}
		
		public static function create_hall($number, $cinema, $rows, $cols, $seats, $seats_map){
			$bd = new HallDAO('complucine');
			if($bd ){
				if(!$bd->searchHall($number, $cinema)){
					$bd->createHall($number, $cinema, $rows, $cols, $seats, $seats_map);
					Seat::createSeats($number, $cinema, $rows, $cols, $seats_map);
					return "Se ha creado la sala con exito";
				} else {
					return "Esta sala ya existe";
				}
			} else { return "Error al conectarse a la base de datos"; }
		}

		public static function edit_hall($number, $cinema, $rows, $cols, $seats, $seats_map, $og_number){
			$bd = new HallDAO('complucine');
			if($bd ){
				if($bd->searchHall($og_number, $cinema)){
					if($og_number == $number){
						Seat::deleteAllSeats($number, $cinema);
						$bd->editHall($number, $cinema, $rows, $cols, $seats, $og_number);
						Seat::createSeats($number, $cinema, $rows, $cols, $seats_map);
						return "Se ha editado la sala con exito";
					}else{
						if(!$bd->searchHall($number, $cinema)){
							Seat::deleteAllSeats($og_number, $cinema);
							$bd->editHall($number, $cinema, $rows, $cols, $seats, $og_number);
							Seat::createSeats($number, $cinema, $rows, $cols, $seats_map);
							return "Se ha editado la sala con exito";
						}else
							return "El nuevo numero de sala ya existe en otra sala";
					}
				} else {
					return "La sala a editar no existe";
				}
			} else { return "Error al conectarse a la base de datos"; }
		}

		public static function delete_hall($number, $cinema, $rows, $cols, $seats, $seats_map, $og_number){
			$bd = new HallDAO('complucine');
			if($bd ){
				if($bd->searchHall($og_number, $cinema)){
					$bd->deleteHall($og_number, $cinema);
					Seat::deleteAllSeats($og_number, $cinema);
					return "La sala se ha eliminado correctamente";
				} else {
					return "La sala a borrar no existe";
				}
			} else { return "Error al conectarse a la base de datos"; }
		}
		
		public static function search_hall($number,$cinema){
			$bd = new HallDAO('complucine');
			if($bd )
				return $bd->searchHall($number,$cinema);;
		}
		
		//Getters && Setters:
        public function setNumber($number){	$this->_number = $number; }
		public function getNumber(){ return $this->_number; }

        public function setIdcinema($idcinema){	$this->_idcinema = $idcinema; }
		public function getIdcinema(){ return $this->_idcinema; }

		public function setNumRows($numRows){ $this->_numRows = $numRows; }
		public function getNumRows(){ return $this->_numRows; }
		
		public function setNumCol($numCol){ $this->_numCol = $numCol; }
		public function getNumCol(){ return $this->_numCol; }

		public function setTotalSeats($totalSeat){ $this->_total_seats = $totalSeat; }
		public function getTotalSeats(){ return $this->_total_seats; }

		public function setSeatsmap($seats_map){ $this->_seats_map = $seats_map; }
		public function getSeatsmap(){ return $this->_seats_map; }

    }
?>