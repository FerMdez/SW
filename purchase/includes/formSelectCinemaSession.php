<?php
include_once($prefix.'assets/php/form.php');
include_once($prefix.'assets/php/includes/film_dao.php');
include_once($prefix.'assets/php/includes/film.php');
include_once($prefix.'assets/php/includes/cinema_dao.php');
include_once($prefix.'assets/php/includes/cinema.php');
include_once($prefix.'assets/php/includes/session_dao.php');
include_once($prefix.'assets/php/includes/session.php');
include_once($prefix.'assets/php/includes/hall_dao.php');
include_once($prefix.'assets/php/includes/hall.php');

class FormSelectCinemaSession extends Form {

    //Atributes:
    //private $session;       // Session of the film to be purchased.
    //private $cinema;        // Cinema of the film to be purchased.
    //private $hall;          // Hall of the film to be purchased.
    //private $film;          // Film to be purchased.
    private $_TODAY;         // Actual date.

    public function __construct() {
        $options = array("action" => "selectSeat.php");
        parent::__construct('formSelectCinemaSession', $options);

        $TODAY = getdate();
        $this->_TODAY = "$TODAY[mday]"."-"."$TODAY[mon]"."-"."$TODAY[year]";
        
    }

    protected function generaCamposFormulario($datos, $errores = array()){
        $cinemas = [];
        $sessions = [];

        // Se generan los mensajes de error, si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorCinema = self::createMensajeError($errores, 'cinemas', 'span', array('class' => 'error'));
        $errorFilm = self::createMensajeError($errores, 'films', 'span', array('class' => 'error'));
        $errorSession = self::createMensajeError($errores, 'sessions', 'span', array('class' => 'error'));
        $errorCode = self::createMensajeError($errores, 'code', 'span', array('class' => 'error'));
        
        $pay = true;
        if(isset($_GET["film"])){
            $filmDAO = new Film_DAO("complucine");
            $film = $filmDAO->FilmData($_GET["film"]);
            if($film){
                $tittle = $film->getTittle();
                $image = $film->getImg();
    
                $cinemas = $filmDAO->getCinemas($_GET["film"]);
                $cinema_id = $_GET["cinema"];
                if(!empty($cinemas)){
                    $cinemasNames = new ArrayIterator(array());
                    $cinemasIDs = new ArrayIterator(array());
                    foreach($cinemas as $key=>$value){
                        $cinemasIDs[$key] = $value->getId();
                        $cinemasNames[$key] = $value->getName();
                    }
                    $cinemasIT = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
                    $cinemasIT->attachIterator($cinemasIDs, "cID");
                    $cinemasIT->attachIterator($cinemasNames, "NAME");
                    
                    $cinemasListHTML = '<section id="select_cinema"><pre>'.$htmlErroresGlobales.'</pre>
                                        <select name="cinemas" id="cinemas"><pre>'.$errorCinema.'</pre>';
                    if(!isset($cinema_id)){
                        $cinemasListHTML .= '<option value="" selected>Selecciona un cine</option>';
                        foreach($cinemasIT as $value){
                            $cinemasListHTML .='<option value="'.$value["cID"].'">'.$value["NAME"].'</option>';
                        }
                    } else {
                        foreach($cinemasIT as $value){
                            if($value["cID"] == $cinema_id){
                                $cinemasListHTML .= '<option value="'.$value["cID"].'" selected>'.$value["NAME"].'</option>';
                            } else {
                                $cinemasListHTML .='<option value="'.$value["cID"].'">'.$value["NAME"].'</option>';
                            }
                        }
                    }
                    $cinemasListHTML .= '</select>
                                </section>';
                } else {
                    $cinemasListHTML = '<select name="cinemas"><option value="" selected>No hay cines disponibles para esta película.</option></select><button id="go-back">Volver</button>';
                }
    
                $fiml_id = $film->getId();
    
                if(isset($cinema_id)){
                    $sessionsDAO = new SessionDAO("complucine");
                    $sessions = $sessionsDAO->getSessions_Film_Cinema($fiml_id, $cinema_id);
                    if(!empty($sessions)){
                        $sessionsDates = new ArrayIterator(array());
                        $sessionsStarts = new ArrayIterator(array());
                        $sessionsHalls = new ArrayIterator(array());
                        $sessionsIDs = new ArrayIterator(array());
                        foreach($sessions as $key=>$value){
                            $sessionsIDs[$key] = $value->getId();
                            $sessionsDates[$key] = date_format(date_create($value->getDate()), 'j-n-Y');
                            $sessionsHalls[$key] = $value->getIdhall();
                            $sessionsStarts[$key] = $value->getStartTime();
                        }
                        $sessionsIT = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
                        $sessionsIT->attachIterator($sessionsIDs, "sID");
                        $sessionsIT->attachIterator($sessionsDates, "DATE");
                        $sessionsIT->attachIterator($sessionsHalls, "HALL");
                        $sessionsIT->attachIterator($sessionsStarts, "HOUR");
    
                        $count = 0;
                        $sessionsListHTML = '<select name="sessions" id="sessions"><pre>'.$errorSession.'</pre>';
                        foreach ($sessionsIT as $value) {
                            if(strtotime($this->_TODAY) <= strtotime($value["DATE"])){
                                if($value === reset($sessionsIT)){
                                    $sessionsListHTML .= '<option value="'.$value["sID"].'" >Fecha: '.$value["DATE"].' | Hora: '.$value["HOUR"].' | Sala: '.$value["HALL"].'</option>';
                                } else {
                                    $sessionsListHTML .='<option value="'.$value["sID"].'">Fecha: '.$value["DATE"].' | Hora:'.$value["HOUR"].' | Sala: '.$value["HALL"].'</option>';
                                }
                                $count++;
                            }
                        }
                        $sessionsListHTML .= '</select>';
    
                        if($count == 0) {
                            $sessionsListHTML = '<select name="sessions"><option value="" selected>No hay sesiones disponibles para esta película.</option></select><button id="go-back">Volver</button>'; 
                            $pay = false;
                        }
                    } else {
                        $sessionsListHTML = '<select name="sessions"><option value="" selected>No hay sesiones disponibles para esta película.</option></select><button id="go-back">Volver</button>';
                        $pay = false;
                    }
                } else {
                    $sessionsListHTML = '<select name="sessions"><option value="" selected>Primero seleccione un cine.</option></select>';
                    $pay = false;
                }
    
                //Reply: Depends on whether the purchase is to be made from a selected movie or a cinema.
                $html = '<div class="column left">
                            <h2>Película seleccionada: '.str_replace('_', ' ', $tittle).'</h2><hr />
                            <div class="image"><img src="../img/films/'.$image.'" alt="'.$tittle.'" /></div>
                            <p>Duración: '.$film->getDuration().' minutos</p>
                            <p>Idioma: '.$film->getLanguage().'</p>
                        </div>
                        <div class="column right">
                            <h2>Seleccione un Cine y una Sesión</h2><hr />
                                <h3>Cines</h3>        
                                '.$cinemasListHTML.'
                                <h3>Sesiones</h3>
                                '.$sessionsListHTML.'
                                <h3><a href="../promotions/" target="_blank">Aplicar código promocional</a><span id="codeValid">&#x2714;</span><span id="codeInvalid">&#x274C;</span></h3>
                                <input type="text" name="code" id="code" value="" placeholder="Código pormocional" /><pre>'.$errorCode.'</pre> 
                        </div>';
            } else {
                $html = '<h1>No existe la película.</h1><button id="go-back">Volver</button>';
                $pay = false;
            }
        } else if(isset($_GET["cinema"])) {
            $pay = false;
            $cinemaDAO = new Cinema_DAO("complucine");
            $cinema = $cinemaDAO->cinemaData($_GET["cinema"]);
            if($cinema){
                $cinema_name = $cinema->getName();
                $cinema_address = $cinema->getDirection();
                $cinema_tlf = $cinema->getPhone();

                $films = $cinemaDAO->getFilms($_GET["cinema"]);
                $film_id = $_GET["film"];
                if(!empty($films)){
                    $filmsNames = new ArrayIterator(array());
                    $filmsIDs = new ArrayIterator(array());
                    foreach($films as $key=>$value){
                        $filmsIDs[$key] = $value->getId();
                        $filmsNames[$key] = str_replace('_', ' ', $value->getTittle());
                    }
                    $filmsIT = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
                    $filmsIT->attachIterator($filmsIDs, "fID");
                    $filmsIT->attachIterator($filmsNames, "NAME");

                    $filmsListHTML = '<section id="select_film"><pre>'.$htmlErroresGlobales.'</pre>
                                        <select name="films" id="films"><pre>'.$errorFilm.'</pre>';
                    if(!empty($films)){
                        $filmsListHTML .= '<option value="" selected>Selecciona una película</option>';
                        foreach($filmsIT as $value){
                            $filmsListHTML .='<option value="'.$value["fID"].'">'.$value["NAME"].'</option>';
                        }
                    } else {
                        foreach($filmsIT as $value){
                            if($value["cID"] == $film_id){
                                $filmsListHTML .= '<option value="'.$value["fID"].'" selected>'.$value["NAME"].'</option>';
                            } else {
                                $filmsListHTML .='<option value="'.$value["fID"].'">'.$value["NAME"].'</option>';
                            }
                        }
                    }
                    $filmsListHTML .= '</select>
                                </section>';

                } else {
                    $filmsListHTML = '<select name="films"><option value="" selected>No hay películas disponibles para este cine.</option></select><button id="go-back">Volver</button>';
                }

                //Reply: Depends on whether the purchase is to be made from a selected movie or a cinema.
                $html = '<div class="column left">
                            <h2>Cine seleccionado: '.$cinema_name.'</h2><hr />
                            <div class="image"><img src="../img/sala1.jpg" alt="'.$cinema_name.'" /></div>
                            <p>Dirección: '.$cinema_address.'</p>
                            <p>Teléfono: '.$cinema_tlf.'</p>
                        </div>
                        <div class="column right">
                            <h2>Seleccione una Película y una Sesión</h2><hr />
                                <h3>Películas</h3>        
                                '.$filmsListHTML.'
                                <h3>Sesiones</h3>
                                <select>
                                    <option value="" selected>Primero selecione una película.</option>
                                <select>
                        </div>';

            } else {
                $html = '<h1>No existe el cine.</h1>
                        <button id="go-back">Volver</button>';
                $pay = false;
            }
        } else {
            $html = '<h1>No se ha encontrado película ni cine.</h1>
                    <button id="go-back">Volver</button>';
            $pay = false;
        }

        //Select seat button:
        if($pay){
            $pay = '<input type="submit" id="submit" value="Seleccionar Asiento" />';
        }

            return '
                    <section class="code purchase">
                        '.$html.'
                    </section>
                    <section class="code purchase">
                        '.$pay.'
                    </section>';
    }

    protected function procesaFormulario($datos){
        $result = array();

        $cinema = $this->test_input($datos['cinemas']) ?? null;
        if ( empty($cinema) ) {
            $result['cinemas'] = "Selecciona un cine.";
        }

        $films = $this->test_input($datos['films']) ?? null;
        if ( empty($films) ) {
            $result['films'] = "Selecciona una película.";
        }

        $session = $this->test_input($datos['sessions']) ?? null;
        if ( empty($session) ) {
            $result['sessions'] = "Selecciona una sesión.";
        }

        $code = $this->test_input($datos['code']) ?? null;
        $avaliable = "../assets/php/common/checkPromo.php?code=".$code;
        if ( !empty($code) && mb_strlen($code) != 8 && $avaliable === "avaliable") {
            $result['code'] = "El código promocional no es válido.";
        }

        if (count($result) === 0) {
            $result = "selectSeat.php";
        }

        return $result;
    }
}
?>