<?php
	include_once($prefix.'assets/php/common/session_dao.php');
	include_once($prefix.'panel_admin/includes/film.php');
	include_once($prefix.'assets/php/common/film_dao.php');

    class Session{

        private $_id;          
        private $_idfilm;
        private $_idhall;
		private $_idcinema;			
        private $_date;
        private $_startTime;
        private $_seatPrice;
        private $_format;
		
        function __construct($id, $idfilm, $idhall, $idcinema, $date, $startTime, $seatPrice, $format){
            $this->_id = $id;
            $this->_idfilm = $idfilm;
            $this->_idhall = $idhall;
			$this->_idcinema = $idcinema;
            $this->_date = $date;
            $this->_startTime = $startTime;
            $this->_seatPrice = $seatPrice;
            $this->_format = $format;
        }

		public static function getListSessions($hall,$cinema,$date){
			$bd = new SessionDAO('complucine');
			if($bd ) {
				return $bd->getAllSessions($hall, $cinema, $date);
			}
			return "";
		}
		
		public static function create_session($session){
			$bd = new SessionDAO('complucine');
			if($bd ){
				if(!$bd->searchSession($session['cinema'], $session['hall'],$session['start'],$session['date'])){
					$bd->createSession(null,$session['film'], $session['hall'], $session['cinema'], $session['date'], 
						$session['start'], $session['price'], $session['format']);
						
					if($session['repeat'] > "0") {
						$repeat = $session['repeat'];
						$session['repeat'] = $session['repeat'] - 1;
						$session['date'] = date('Y-m-d', strtotime( $session['date'] . ' +1 day') );
						self::create_session($session);
						return "Se han creado las ".$repeat ." sesiones con exito";
					}
						
					else
						return "Se ha creado la session con exito";
				} else 
					return "Esta session ya existe";
				
			} else return "Error al conectarse a la base de datos";
		}

		public static function edit_session($session){
			$bd = new SessionDAO('complucine');
			if($bd ){
				if($bd->searchSession($session['cinema'], $session['origin_hall'],$session['origin_start'],$session['origin_date'])){
					$origin = array("cinema" => $session['cinema'],"hall" => $session['origin_hall'],"start" => $session['origin_start'],"date" => $session['origin_date']);
					$bd->editSession($session['film'], $session['hall'], $session['cinema'], $session['date'], 
						$session['start'], $session['price'], $session['format'],$origin);
					return "Se ha editado la session con exito";						
				} else 
					return "Esta session no existe";
				
			} else return "Error al conectarse a la base de datos";
		}

		public static function delete_session($session){
			$bd = new SessionDAO('complucine');
			if($bd ){
				if($bd->searchSession($session['cinema'], $session['hall'],$session['start'],$session['date'])){
					$bd->deleteSession($session['hall'], $session['cinema'], $session['date'], $session['start']);
					return "Se ha eliminado la session con exito";						
				} else 
					return "Esta session no existe";
				
			} else return "Error al conectarse a la base de datos";
		}


		//Esto deberia estar en film.php? seguramente
		public static function getFilmTitle($idfilm){
			$bd = new Film_DAO('complucine');
			if($bd ) {
				$film = mysqli_fetch_array($bd->FilmData($idfilm));
				return $film["tittle"];
			}
			return "";
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

    }
?>