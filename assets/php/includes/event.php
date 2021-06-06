<?php

include_once($prefix.'assets/php/includes/session.php');

//Full calendar only accepts Events objects
class Event implements \JsonSerializable
{
    public static function searchAllEvents($idhall, $cinema)
    {
        $result = [];
		$sessions = Session::getListSessions($idhall,$cinema,null);
		
		foreach($sessions as $s){
			$e = new Event();
			$diccionario = self::session2dictionary($s);
			$e = $e->dictionary2event($diccionario);
			$result[] = $e;
		}
		
        return $result;
    }
  
    public static function searchEventsBetween2dates(string $start, string $end = null, $idhall, $cinema)
    {	
        $startDate = \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $start);
		$endDate =  \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $end);
        
        $result = [];
		
        $sessions = Session::getListSessionsBetween2Dates($idhall,$cinema,$startDate,$endDate);
		
		foreach($sessions as $s){
			$e = new Event();
			$dictionary = self::session2dictionary($s);
			$e = $e->dictionary2event($dictionary);
			$result[] = $e;
		}
		
        return $result;
    }

    const MYSQL_DATE_TIME_FORMAT= 'Y-m-d H:i:s';
    
    private $id;
    private $title;
    private $start;
    private $end;

	private $idfilm;
    private $start_time;
	private $seat_price;
    private $format;
    private $seats_full;


    private function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }
	
     public function getIdfilm()
    {
        return $this->idfilm;
    }

    //Return an object that allows Event object to be serialized as json because private atributes cant be serialized
    public function jsonSerialize()
    {	
        $o = new \stdClass();
        $o->id = $this->id;
        $o->title = $this->title;
        $o->start = $this->start->format(self::MYSQL_DATE_TIME_FORMAT);
        $o->end = $this->end->format(self::MYSQL_DATE_TIME_FORMAT);
        $o->start_time = $this->start_time;
		$o->seat_price = $this->seat_price;
        $o->format = $this->format;
		$o->film = Session::getThisSessionFilm($this->idfilm);
		$o->date = $this->start->format("Y-m-d");
		
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
			"title" => $tittle,
			"start" => $start,
			"end" => $end,
			"idfilm" => $session->getIdfilm(),
			"start_time" => $session->getStartTime(),
			"seat_price" => $session->getSeatPrice(),
			"format" => $session->getFormat(),
			"seats_full" => $session->getSeatsFull(),
		);
		
		return $dictionary;
	}
    
    protected function dictionary2event(array $dictionary)
    {
        if (array_key_exists('id', $dictionary)) {
            $id = $dictionary['id'];
            $this->id =(int)$id;
        }

        if (array_key_exists('title', $dictionary)) {
            $title = $dictionary['title'];
            $this->title = $title;
        }
        
        if (array_key_exists('start', $dictionary)) {
            $start = $dictionary['start'];
			$startDate = \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $start);
            $this->start = $startDate;
        }

        
        if (array_key_exists('end', $dictionary)) {
            $end = $dictionary['end'] ?? null;
            $endDate = \DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $end);
            $this->end = $endDate;
        }
		
		if (array_key_exists('idfilm', $dictionary)) {
            $idfilm = $dictionary['idfilm'] ?? null;
            $this->idfilm = $idfilm;
        }
		
		if (array_key_exists('start_time', $dictionary)) {
            $start_time = $dictionary['start_time'] ?? null;
            $this->start_time = $start_time;
        }
		
		if (array_key_exists('seat_price', $dictionary)) {
            $seat_price = $dictionary['seat_price'] ?? null;
            $this->seat_price = $seat_price;
        }
		
		if (array_key_exists('format', $dictionary)) {
            $format = $dictionary['format'] ?? null;
            $this->format = $format;
        }
		
		if (array_key_exists('seats_full', $dictionary)) {
            $seats_full = $dictionary['seats_full'] ?? null;
            $this->seats_full = $seats_full;
        }
        
        return $this;
    }
}
