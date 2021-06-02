<?php
	include_once('session_dao.php');

    class Session{

        private $_id;          
        private $_idfilm;
        private $_idhall;
		private $_idcinema;			
        private $_date;
        private $_startTime;
        private $_seatPrice;
        private $_format;
		private $_seats_full;
		
        function __construct($id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format, $seats_full){
            $this->_id = $id;
            $this->_idfilm = $idfilm;
            $this->_idhall = $idhall;
			$this->_idcinema = $idcinema;
            $this->_date = $date;
            $this->_startTime = $startTime;
            $this->_seatPrice = $seatPrice;
            $this->_format = $format;
			$this->_seats_full = $seats_full;
        }

		public static function getListSessions($hall,$cinema,$date){
			$bd = new SessionDAO('complucine');
			if($bd ) {
				if($date)
					return $bd->getAllSessions($hall, $cinema, $date, null);
				else
					return $bd->getAllSessions($hall, $cinema, null, null);
			}
		}
		public static function getListSessionsBetween2Dates($hall,$cinema,$start,$end){
			$bd = new SessionDAO('complucine');
			if($bd ) {
				return $bd->getAllSessions($hall, $cinema, $start, $end);
			}
		}
		
		public static function create_session($cinema, $hall, $start, $date, $film, $price, $format,$repeat){
			$bd = new SessionDAO('complucine');
			if($bd ){
				if(!$bd->searchSession($cinema, $hall, $start, $date)){
					$bd->createSession(null,$film, $hall, $cinema, $date, $start, $price, $format);

					if($repeat > "0") {
						$repeats = $repeat;
						$repeat = $repeat - 1;
						$date = date('Y-m-d', strtotime( $date . ' +1 day') );
						self::create_session($cinema, $hall, $start, $date, $film, $price, $format,$repeat);
						return "Se han creado las ".$repeat ." sesiones con exito";
					}
						
					else
						return "Se ha creado la session con exito";
				} else 
					return "Esta session ya existe";
				
			} else return "Error al conectarse a la base de datos";
		}
		
		public static function edit_session($cinema, $or_hall, $or_date, $or_start, $hall, $start, $date, $film, $price, $format){
			$bd = new SessionDAO('complucine');
			if($bd ){
				if($bd->searchSession($cinema, $or_hall, $or_start, $or_date)){
					if(!$bd->searchSession($cinema,$hall,$start,$date)){
						$origin = array("cinema" => $cinema,"hall" => $or_hall,"start" => $or_start,"date" => $or_date);
						$bd->editSession($film, $hall, $cinema, $date, $start, $price, $format,$origin);
						return "Se ha editado la session con exito";			
					}else if($or_hall == $hall && $or_start == $start && $or_date == $date){
						$origin = array("cinema" => $cinema,"hall" => $or_hall,"start" => $or_start,"date" => $or_date);
						$bd->editSession($film, $hall, $cinema, $date, $start, $price, $format, $origin);
						return "Se ha editado la session con exito";
					}else{
						return "Ya existe una sesion con los parametros nuevos";	
					}
						
				} else 
					return "La session a editar no existe";
				
			} else return "Error al conectarse a la base de datos";
		}

		public static function delete_session($cinema, $hall, $start, $date){
			$bd = new SessionDAO('complucine');
			if($bd ){
				if($bd->searchSession($cinema, $hall, $start, $date)){
					$bd->deleteSession($hall, $cinema, $date, $start);
					return "Se ha eliminado la session con exito";						
				} else 
					return "Esta session no existe";
				
			} else return "Error al conectarse a la base de datos";
		}
		
		//Esto deberia estar en film.php? seguramente
		public static function getThisSessionFilm($idfilm){
			$bd = new SessionDAO('complucine');
			if($bd ) {
				return $bd->filmTittle($idfilm);
			}
		}
		
        public function setId($id){	$this->_id = $id; }
		public function getId(){ return $this->_id; }

        public function setIdfilm($idfilm){ $this->_idfilm = $idfilm; }
		public function getIdfilm(){ return $this->_idfilm; }
        
        public function setIdhall($idhall){ $this->_idhall = $idhall; }
		public function getIdhall(){ return $this->_idhall; }
		
		public function setIdcinema($cinema){ $this->_idcinema = $idcinema; }
		public function getIdcinema(){ return $this->_idcinema; }

		public function setDate($date){ $this->_date = $date; }
		public function getDate(){ return $this->_date; }

		public function setStartTime($startTime){ $this->_startTime = $startTime; }
		public function getStartTime(){ return $this->_startTime; }

		public function setSeatPrice($seatPrice){ $this->_seatPrice = $seatPrice; }
		public function getSeatPrice(){ return $this->_seatPrice; }

		public function setFormat($format){ $this->_format = $format; }
		public function getFormat(){ return $this->_format; }

		public function setSeatsFull($bool){ $this->_seats_full = $bool; }
		public function getSeatsFull(){ return $this->_seats_full; }

    }
?>