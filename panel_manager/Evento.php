<?php

include_once($prefix.'assets/php/includes/session.php');

/**
 * Representa un evento de calendario.
 */
class Evento implements \JsonSerializable
{

    /**
     * Busca todos los eventos de un usuario con id $userId.
     *
     * @param int $userId Id del usuario a buscar.
     *
     * @return array[Evento] Lista de eventos del usuario con id $userId.
     */
    public static function buscaTodosEventos(int $userId, $idhall, $cinema)
    {
        if (!$userId) {
           // throw new \BadMethodCallException('$userId no puede ser nulo.');
        }
		
        $result = [];
		$sessions = Session::getListSessions($idhall,$cinema,null);
		
		foreach($sessions as $s){
			$e = new Evento();
			$diccionario = self::session2dictionary($s);
			$e = $e->asignaDesdeDiccionario($diccionario);
			$result[] = $e;
		}
		
        return $result;
    }

    /**
     * Busca un evento con id $idEvento.
     *
     * @param int $idEvento Id del evento a buscar.
     *
     * @return Evento Evento encontrado.
     */
    public static function buscaPorId(int $idEvento, $idhall, $cinema)
    {
        if (!$idEvento) {
            throw new \BadMethodCallException('$idEvento no puede ser nulo.');
        }

        $result = null;
        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT E.id, E.title, E.userId, E.startDate AS start, E.endDate AS end FROM Eventos E WHERE E.id = %d", $idEvento);
        $rs = $conn->query($query);
        if ($rs && $rs->num_rows == 1) {
            while($fila = $rs->fetch_assoc()) {
                $result = new Evento();
                $result->asignaDesdeDiccionario($fila);
            }
            $rs->free();
        } else {
            if ($conn->affected_rows == 0) {
                throw new EventoNoEncontradoException("No se ha encontrado el evento: ".$idEvento); 
            }
            throw new DataAccessException("Se esperaba 1 evento y se han obtenido: ".$rs->num_rows);
        }
        return $result;
    }
  
    /**
     * Busca los eventos de un usuario con id $userId en el rango de fechas $start y $end (si se proporciona).
     *
     * @param int $userId Id del usuario para el que se buscarán los eventos.
     * @param string $start Fecha a partir de la cual se buscarán eventos (@link MYSQL_DATE_TIME_FORMAT)
     * @param string|null $end Fecha hasta la que se buscarán eventos (@link MYSQL_DATE_TIME_FORMAT)
     *
     * @return array[Evento] Lista de eventos encontrados.
     */
    public static function buscaEntreFechas(int $userId, string $start, string $end = null, $idhall, $cinema)
    {	
        if (!$userId) {
            //throw new \BadMethodCallException('$userId no puede ser nulo.');
        }
        
        $startDate = \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $start);
        if (!$startDate) {
           // throw new \BadMethodCallException('$diccionario[\'start\'] no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
        }
        
        $endDate = null;
        if ($end) {
            $endDate =  \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $end);
            if (!$endDate) {
               // throw new \BadMethodCallException('$diccionario[\'end\'] no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
            }
        }
        
        if ($endDate) {

        }
        
        $result = [];
		
        $sessions = Session::getListSessionsBetween2Dates($idhall,$cinema,$startDate,$endDate);
		
		foreach($sessions as $s){
			$e = new Evento();
			$diccionario = self::session2dictionary($s);
			$e = $e->asignaDesdeDiccionario($diccionario);
			$result[] = $e;
		}
		
        return $result;
    }

    /**
     * Guarda o actualiza un evento $evento en la BD.
     *
     * @param Evento $evento Evento a guardar o actualizar.
     */
    public static function guardaOActualiza(Evento $evento)
    {
        if (!$evento) {
            throw new \BadMethodCallException('$evento no puede ser nulo.');
        }
        $result = false;
        $app = App::getSingleton();
        $conn = $app->conexionBd();
        if (!$evento->id) {
            $query = sprintf("INSERT INTO Eventos (userId, title, startDate, endDate) VALUES (%d, '%s', '%s', '%s')"
                , $evento->userId
                    , $conn->real_escape_string($evento->title)
                        , $evento->start->format(self::MYSQL_DATE_TIME_FORMAT)
                            , $evento->end->format(self::MYSQL_DATE_TIME_FORMAT));

            $result = $conn->query($query);
            if ($result) {
                $evento->id = $conn->insert_id;
                $result = $evento;
            } else {
                throw new DataAccessException("No se ha podido guardar el evento");
            }
        } else {
            $query = sprintf("UPDATE Eventos E SET userId=%d, title='%s', startDate='%s', endDate='%s' WHERE E.id = %d"
                , $evento->userId
                    , $conn->real_escape_string($evento->title)
                        , $evento->start->format(self::MYSQL_DATE_TIME_FORMAT)
                            , $evento->end->format(self::MYSQL_DATE_TIME_FORMAT)
                                , $evento->id);      
            $result = $conn->query($query);
            if ($result) {
                $result = $evento;
            } else {
                throw new DataAccessException("Se han actualizado más de 1 fila cuando sólo se esperaba 1 actualización: ".$conn->affected_rows);
            }
        }

        return $result;
    }
  
    /**
     * Borra un evento id $idEvento.
     *
     * @param int $idEvento Id del evento a borrar.
     *
     */
    public static function borraPorId(int $idEvento)
    {
        if (!$idEvento) {
            throw new \BadMethodCallException('$idEvento no puede ser nulo.');
        }
        $result = false;
        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf('DELETE FROM Eventos WHERE id=%d', $idEvento);
        $result = $conn->query($query);
        if ($result && $conn->affected_rows == 1) {
            $result = true;
        } else {
            if ($conn->affected_rows == 0) {
                throw new EventoNoEncontradoException("No se ha encontrado el evento: ".$idEvento); 
            }
            throw new DataAccessException("Se esperaba borrar 1 fila y se han borrado: ".$conn->affected_rows); 
        }
        return $result;
    }
  
    /**
     * Crear un evento asociado a un usuario $userId y un título $title.
     * El comienzo es la fecha y hora actual del sistema y el fin es una hora más tarde.
     *
     * @param int $userId Id del propietario del evento.
     * @param string $title Título del evento.
     *
     */
    public static function creaSimple(int $userId, string $title)
    {
        $start = new \DateTime();
        $end = $start->add(new \DateInterval('PT1H'));
        return self::creaDetallado($userId, $title, $start, $end);
    }
  
    /**
     * Crear un evento asociado a un usuario $userId, un título $title y una fecha y hora de comienzo.
     * El fin es una hora más tarde de la hora de comienzo.
     *
     * @param int $userId Id del propietario del evento.
     * @param string $title Título del evento.
     * @param DateTime $start Fecha y horas de comienzo.
     */
    public static function creaComenzandoEn(int $userId, string $title, \DateTime $start)
    {    
        if (empty($start)) {
            throw new \BadMethodCallException('$start debe ser un timestamp valido no nulo');
        }

        $end = $start->add(new \DateInterval('PT1H'));
        return self::creaDetallado($userId, $title, $start, $end);
    }
  
    /**
     * Crear un evento asociado a un usuario $userId, un título $title y una fecha y hora de comienzo y fin.
     *
     * @param int $userId Id del propietario del evento.
     * @param string $title Título del evento.
     * @param DateTime $start Fecha y horas de comienzo.
     * @param DateTime $end Fecha y horas de fin.
     */
    public static function creaDetallado(int $userId, string $title, \DateTime $start, \DateTime $end)
    {
        $e = new Evento();
        $e->setUserId($userId);
        $e->setTitle($title);
        $e->setStart($start);
        $e->setEnd($end);
    }

    /**
     * Crear un evento un evento a partir de un diccionario PHP.
     * Como por ejemplo array("userId" => (int)1, "title" => "Descripcion"
     *   , "start" => "2019-04-29 00:00:00", "end" => "2019-04-30 00:00:00")
     *
     * @param array $diccionario Array / map / diccionario PHP con los datos del evento a crear.
     *
     * @return Evento Devuelve el evento creado.
     */
    public static function creaDesdeDicionario(array $diccionario)
    {
        $e = new Evento();
        $e->asignaDesdeDiccionario($diccionario, ['userId', 'title', 'start', 'end']);
        return $e;
    }
    
    /**
     * Comprueba si $start y $end son fechas y además $start es anterior a $end.
     */
    private static function compruebaConsistenciaFechas(\DateTime $start, \DateTime $end)
    {
        if (!$start) {
            throw new \BadMethodCallException('$start no puede ser nula');
        }
        
        if (!$end) {
            throw new \BadMethodCallException('$end no puede ser nula');
        }

        if ($start >= $end) {
            throw new \BadMethodCallException('La fecha de comienzo $start '.$start->format("Y-m-d H:i:s").' no puede ser posterior a la de fin $end '.$end->format("Y-m-d H:i:s"));
        }
    }
	
    /**
     * @param int Longitud máxima del título de un evento.
     */
    const TITLE_MAX_SIZE = 255;

    /**
     * @param string Formato de fecha y hora compatible con MySQL.
     */
    const MYSQL_DATE_TIME_FORMAT= 'Y-m-d H:i:s';

    /**
     * @param array[string] Nombre de las propiedades de la clase.
     */
    const PROPERTIES = ['id', 'userId', 'title', 'start', 'end', 'idfilm'];
	//'idfilm','idhall','idcinema','date', 'start_time', 'seat_price', 'format', 'seats_full'];
    
    private $id;
    private $userId;
    private $title;
    private $start;
    private $end;

	private $idfilm;
   
	
    /*
	 private $idhall;
	private $idcinema;
    private $date;
    private $start_time;
	private $seat_price;
    private $format;
    private $seats_full;*/


    private function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }
	
    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId(int $userId)
    {
        if (is_null($userId)) {
            throw new \BadMethodCallException('$userId no puede ser una cadena vacía o nulo');
        }
        $this->userId = $userId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        if (is_null($title)) {
            throw new \BadMethodCallException('$title no puede ser una cadena vacía o nulo');
        }

        if (mb_strlen($title) > self::TITLE_MAX_SIZE) {
            throw new \BadMethodCallException('$title debe tener como longitud máxima: '.self::TITLE_MAX_SIZE);
        }
        $this->title = $title;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart(\DateTime $start)
    {      
        if (empty($start)) {
            throw new \BadMethodCallException('$start debe ser un timestamp valido no nulo');
        }
        if (! is_null($this->end) ) {
            self::compruebaConsistenciaFechas($start, $this->end);
        }
        $this->start = $start;
    }

    public function getEnd()
    {    
        if (empty($end)) {
            throw new \BadMethodCallException('$end debe ser un timestamp valido no nulo');
        }

        return $this->end;
    }

    public function setEnd(\DateTime $end)
    {      
        if (empty($end)) {
            throw new \BadMethodCallException('$end debe ser un timestamp valido no nulo');
        }

        self::compruebaConsistenciaFechas($this->start, $end);
        $this->end = $end;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
   
    /**
     * Método utilizado por la función de PHP json_encode para serializar un objeto que no tiene atributos públicos.
     *
     * @return Devuelve un objeto con propiedades públicas y que represente el estado de este evento.
     */
    public function jsonSerialize()
    {
        $o = new \stdClass();
        $o->id = $this->id;
        $o->userId = $this->userId;
        $o->title = $this->title;
        $o->start = $this->start->format(self::MYSQL_DATE_TIME_FORMAT);
        $o->end = $this->end->format(self::MYSQL_DATE_TIME_FORMAT);
        return $o;
    }
 
	public static function session2dictionary($session){
		$extraDurationBetweenFilms = 10;
		
		$film =	Session::getThisSessionFilm($session->getIdfilm());
		$dur = $film["duration"]+$extraDurationBetweenFilms;
		
		$tittle = str_replace('_', ' ', $film["tittle"]) ;
		$start = $session->getDate()." ".$session->getStartTime();
		
		$end = date('Y-m-d H:i:s', strtotime( $start . ' +'.$dur.' minute'));
		
		$dictionary = array(
			"id" => $session->getId(),
			"userId" => "80",
			"title" => $tittle,
			"start" => $start,
			"end" => $end,
			"idfilm" => $session->getIdfilm(),
			/*"idcinema" => $session->getIdcinema(),
			"idhall" => $session->getIdhall(),
			"date" => $session->getDate(),
			"start_time" => $session->getStartTime(),
			"seat_price" => $session->getSeatPrice(),
			"format" => $session->getFormat(),
			"seats_full" => $session->getSeatsFull(),*/
		);
		
		return $dictionary;
	}
    /**
     * Actualiza este evento a partir de un diccionario PHP. No todas las propiedades tienen que actualizarse.
     * Por ejemplo el array("title" => "Nueva descripcion", "end" => "2019-04-30 00:00:00") sólo actualiza las 
     * propiedades "title" y "end".
     *
     * @param array $diccionario Array / map / diccionario PHP con los datos del evento a actualizar.
     * @param array[string] $propiedadesAIgnorar Nombre de propiedades que se ignorarán, y no se actualizarán, si se
     *                                           encuentran en $diccionario.
     *
     */
    public function actualizaDesdeDiccionario(array $diccionario, array $propiedadesAIgnorar = [])
    {
        $propiedadesAIgnorar[] = 'id';

        foreach($propiedadesAIgnorar as $prop) {
            if( isset($diccionario[$prop]) ) {
                unset($diccionario[$prop]);
            }
        }
        
        return $this->asignaDesdeDiccionario($diccionario);
    }
    
    /**
     * Actualiza este evento a partir de un diccionario PHP. No todas las propiedades tienen que actualizarse, aunque son
     * obligatorias las propiedades cuyo nombre se incluyan en $propiedadesRequeridas.
     *
     * @param array $diccionario Array / map / diccionario PHP con los datos del evento a actualizar.
     * @param array[string] $propiedadesRequeridas Nombre de propiedades que se requieren actualizar. Si no existen en
     *                                             $diccionario, se lanza BadMethodCallException.
     *
     */
    protected function asignaDesdeDiccionario(array $diccionario, array $propiedadesRequeridas = [])
    {
        foreach($diccionario as $key => $val) {
            if (!in_array($key, self::PROPERTIES)) {
                throw new \BadMethodCallException('Propiedad no esperada en $diccionario: '.$key);
            }
        }

        foreach($propiedadesRequeridas as $prop) {
            if( ! isset($diccionario[$prop]) ) {
                throw new \BadMethodCallException('El array $diccionario debe tener las propiedades: '.implode(',', $propiedadesRequeridas));
            }
        }

        if (array_key_exists('id', $diccionario)) {
            $id = $diccionario['id'];
            if (empty($id)) {
                throw new \BadMethodCallException('$diccionario[\'id\'] no puede ser una cadena vacía o nulo');
            } else if (! ctype_digit($id)) {
                throw new \BadMethodCallException('$diccionario[\'id\'] tiene que ser un número entero');
            } else {
                $this->id =(int)$id;
            }
        }

        if (array_key_exists('userId', $diccionario)) {
            $userId = $diccionario['userId'];
            if (empty($userId)) {
                throw new \BadMethodCallException('$diccionario[\'userId\'] no puede ser una cadena vacía o nulo');
            } else if (!is_int($userId) && ! ctype_digit($userId)) {
                throw new \BadMethodCallException('$diccionario[\'userId\'] tiene que ser un número entero: '.$userId);
            } else {
                $this->setUserId((int)$userId);
            }
        }
       

        if (array_key_exists('title', $diccionario)) {
            $title = $diccionario['title'];
            if (is_null($title)) {
                throw new \BadMethodCallException('$diccionario[\'title\'] no puede ser una cadena vacía o nulo');
            } else {
                $this->setTitle($title);
            }
        }

        
        if (array_key_exists('start', $diccionario)) {
            $start = $diccionario['start'];
            if (empty($start)) {
                throw new \BadMethodCallException('$diccionario[\'start\'] no puede ser una cadena vacía o nulo');
            } else {
                $startDate = \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $start);
                if (!$startDate) {
                    throw new \BadMethodCallException('$diccionario[\'start\']: '.$diccionario['start'].' no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
                }
                $this->start = $startDate;
            }
        }

        
        if (array_key_exists('end', $diccionario)) {
            $end = $diccionario['end'] ?? null;
            if (empty($end)) {
                throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
            } else {
                $endDate = \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $end);
                if (!$endDate) {
                    throw new \BadMethodCallException('$diccionario[\'end\']: '.$diccionario['end'].' no sigue el formato válido: '.self::MYSQL_DATE_TIME_FORMAT);
                }
                $this->end = $endDate;
            }
        }
		
		if (array_key_exists('idfilm', $diccionario)) {
            $idfilm = $diccionario['idfilm'] ?? null;
            if (empty($idfilm)) {
               // throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
            } else {
                $this->idfilm = $idfilm;
            }
        }
		
        /*
		if (array_key_exists('idhall', $diccionario)) {
            $idhall = $diccionario['idhall'] ?? null;
            if (empty($idhall)) {
               // throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
            } else {
                $this->idhall = $idhall;
            }
        }
		
		if (array_key_exists('idcinema', $diccionario)) {
            $idcinema = $diccionario['idcinema'] ?? null;
            if (empty($idcinema)) {
               // throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
            } else {
                $this->idcinema = $idcinema;
            }
        }
		
		if (array_key_exists('date', $diccionario)) {
            $date = $diccionario['date'] ?? null;
            if (empty($date)) {
               // throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
            } else {
                $this->date = $date;
            }
        }
		
		if (array_key_exists('start_time', $diccionario)) {
            $start_time = $diccionario['start_time'] ?? null;
            if (empty($start_time)) {
               // throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
            } else {
                $this->start_time = $start_time;
            }
        }
		
		if (array_key_exists('seat_price', $diccionario)) {
            $seat_price = $diccionario['seat_price'] ?? null;
            if (empty($seat_price)) {
               // throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
            } else {
                $this->seat_price = $seat_price;
            }
        }
		
		if (array_key_exists('format', $diccionario)) {
            $format = $diccionario['format'] ?? null;
            if (empty($format)) {
               // throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
            } else {
                $this->format = $format;
            }
        }
		
		if (array_key_exists('seats_full', $diccionario)) {
            $seats_full = $diccionario['seats_full'] ?? null;
            if (empty($seats_full)) {
               // throw new \BadMethodCallException('$diccionario[\'end\'] no puede ser una cadena vacía o nulo');
            } else {
                $this->seats_full = $seats_full;
            }
        }*/
		
        self::compruebaConsistenciaFechas($this->start, $this->end);
        
        return $this;
    }
}
