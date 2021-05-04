<?php
	include_once($prefix.'assets/php/common/hall_dao.php');

    class Hall{

        //Attributes:
        private $_number;      //Room number.
        private $_idcinema;    //Cinema Id
		private $_numRows;     //Num rows.
        private $_numCol;      //Num columns.

		//Constructor:
        function __construct($number, $idcinema, $numRows, $numCol){
            $this->_number = $number;
            $this->_idcinema = $idcinema;
            $this->_numRows = $numRows;
			$this->_numCol = $numCol;
        }

		//Methods:
		public static function getListHalls($cinema){
			$bd = new HallDAO('complucine');
			if($bd )
				return $bd->getAllHalls($cinema);
			return "";
		}
		
		public static function create_hall($hall){
			$bd = new HallDAO('complucine');
			if($bd ){
				if(!$bd->searchHall($hall['cinema'], $hall['number'])){
					$bd->createHall($hall['number'], $hall['cinema'], $hall['cols'], $hall['rows']);
					return "Se ha creado la sala con exito";
				} else {
					return "Esta sala ya existe";
				}
			} else { return "Error al conectarse a la base de datos"; }
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



    }
?>