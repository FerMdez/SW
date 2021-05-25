<?php
include_once($prefix.'assets/php/form.php');
include_once($prefix.'assets/php/includes/session_dao.php');
include_once($prefix.'assets/php/includes/session.php');
include_once($prefix.'assets/php/includes/film_dao.php');
include_once($prefix.'assets/php/includes/film.php');
include_once($prefix.'assets/php/includes/cinema_dao.php');
include_once($prefix.'assets/php/includes/cinema.php');

class FormPurchase extends Form {

    //Atributes:
    private $session;       // Session of the film to be purchased.
    private $cinema;        // Cinema of the film to be purchased.
    private $film;          // Film to be purchased.
    private $years;         // Actual year.
    private $months;        // Months of the year.

    public function __construct() {
        parent::__construct('formPurchase');

        $sessionDAO = new SessionDAO("complucine");
        $this->session = $sessionDAO->sessionData($_POST["session_id"]);

        $filmDAO = new Film_DAO("complucine");  
        $this->film = $filmDAO->FilmData($this->session->getIdfilm());

        $cinemaDAO = new Cinema_DAO("complucine");  
        $this->cinema = $cinemaDAO->cinemaData($this->session->getIdcinema());

        $TODAY = getdate();
        $year = "$TODAY[year]";

        $this->years = array();
        for($i = $year; $i < $year+10; $i++) array_push($this->years, $i);

        $this->months = array();
        for($i = 1; $i <= 12; $i++) array_push($this->months, $i);
    }

    protected function generaCamposFormulario($datos, $errores = array()){

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));

        $monthsHTML = "";
        foreach($this->months as $value){
            $monthsHTML .= "<option>".$value."</option>";
        }

        $yearsHTML = "";
        foreach($this->years as $value){
            $yearsHTML .= "<option>".$value."</option>";
        }

        $html = "<div class='row'>
                            <fieldset id='datos_entrada'>
                                <legend>Resumen de la Compra</legend>
                                <p>Película: ".str_replace('_', ' ', strtoupper($this->film->getTittle()))."</p>
                                <p>Cine: ".$this->cinema->getName()."</p>
                                <p>Sala: ".$this->session->getIdhall()."</p>
                                <p>Fecha: ".date_format(date_create($this->session->getDate()), 'd-m-Y')."</p>
                                <p>Hora: ".$this->session->getStartTime()."</p>
                                <p>Precio: ".$this->session->getSeatPrice()."€</p>
                            </fieldset>
                            <fieldset id='pagar_entrada'><pre>".$htmlErroresGlobales."</pre>
                                <legend>Datos Bancarios</legend>
                                <label for='card-holder'>Titular de la Tarjeta:</label><br />
                                    <input type='text' id='card-holder' class='card-holder' required />
                                <br />
                                <label for='card-number'>Número de Tarjeta: </label><br />
                                    <input type='num' id='card-number-0' class='input-cart-number' placeholder='XXXX' maxlength='4' required />
                                    <input type='num' id='card-number-1' class='input-cart-number' placeholder='XXXX' maxlength='4' required />
                                    <input type='num' id='card-number-2' class='input-cart-number' placeholder='XXXX' maxlength='4' required />
                                    <input type='num' id='card-number-3' class='input-cart-number' placeholder='XXXX' maxlength='4' required />    
                                <label for='card-cvv'>CVV: </label>
                                    <input type='text' id='card-cvv' class='fieldset-cvv' maxlength='3' placeholder='XXX' required />
                                <br />
                                <label for='card-expiration'>Fecha de Expiración:</label><br />
                                    <select id='card-expiration-month' required>
                                    ".$monthsHTML."
                                    </select>
                                    <select id='card-expiration-year' required>
                                    ".$yearsHTML."
                                    </select>
                            </fieldset>
                            <div class='actions'> 
                                <input type='submit' id='submit' value='Pagar' class='primary' />
                                <input type='reset' id='reset' value='Borrar' />       
                            </div>
                        </div>";

        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        
        //$nombre = $this->test_input($datos['name']) ?? null;
        $nombre = $datos['name'] ?? null;
        $nombre = strtolower($nombre);
        if ( empty($nombre) || mb_strlen($nombre) < 3 || mb_strlen($nombre) > 15 ) {
            $result['name'] = "El nombre tiene que tener\n una longitud de al menos\n 3 caracteres\n y menos de 15 caracteres.";
        }
        
        //$password = $this->test_input($datos['pass']) ?? null;
        $password = $datos['pass'] ?? null;
        if ( empty($password) || mb_strlen($password) < 4 ) {
            $result['pass'] = "El password tiene que tener\n una longitud de al menos\n 4 caracteres.";
        }
        
        if (count($result) === 0) {
           $result[] = "La compra aun está en desarrollo. Vuelva en unos días.";
        }

        return $result;
    }
}
?>