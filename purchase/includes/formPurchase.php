<?php
include_once($prefix.'assets/php/form.php');
include_once($prefix.'assets/php/includes/session_dao.php');
include_once($prefix.'assets/php/includes/session.php');
include_once($prefix.'assets/php/includes/film_dao.php');
include_once($prefix.'assets/php/includes/film.php');
include_once($prefix.'assets/php/includes/cinema_dao.php');
include_once($prefix.'assets/php/includes/cinema.php');
include_once($prefix.'assets/php/includes/hall_dao.php');
include_once($prefix.'assets/php/includes/hall.php');
include_once($prefix.'assets/php/includes/seat_dao.php');
include_once($prefix.'assets/php/includes/seat.php');
include_once($prefix.'assets/php/includes/purchase_dao.php');
include_once($prefix.'assets/php/includes/purchase.php');
include_once($prefix.'assets/php/includes/promotion_dao.php');
include_once($prefix.'assets/php/includes/user.php');

class FormPurchase extends Form {

    //Atributes:
    private $film;          // Film to be purchased.
    private $session;       // Session of the film to be purchased.
    private $cinema;        // Cinema of the film to be purchased.
    private $hall;          // Hall of the film to be purchased.
    private $seat;          // Seat of the film to be purchased. 
    private $row;           // Row of the seat.
    private $col;           // Column of the seat.
    private $code;          // Promotional code.
    private $years;         // Actual year.
    private $months;        // Months of the year.
    private $_TODAY;        // Actual date.

    public function __construct() {
        parent::__construct('formPurchase');

        $sessionDAO = new SessionDAO("complucine");
        $this->session = $sessionDAO->sessionData($_POST["sessions"]);

        $filmDAO = new Film_DAO("complucine");  
        $this->film = $filmDAO->FilmData($this->session->getIdfilm());

        $cinemaDAO = new Cinema_DAO("complucine");  
        $this->cinema = $cinemaDAO->cinemaData($this->session->getIdcinema());

        $hallDAO = new HallDAO("complucine");
        $this->hall = $hallDAO->HallData($this->session->getIdhall());

        $this->seat = array();
        $this->row = array();
        $this->col = array();
        $rows = $this->hall->getNumRows();
        $cols = $this->hall->getNumCol();
        for($i = 0; $i <= $rows; $i++){
            for($j = 0; $j <= $cols; $j++){
                $seat = $i.$j;
                if(isset($_POST["checkbox".$seat])){
                    array_push($this->seat, $i."-".$j);
                    array_push($this->row, $i); 
                    array_push($this->col, $j); 
                }
            }
        }

        $promoDAO = new Promotion_DAO("complucine");
        $this->code = intval(0);
        if(isset($_POST["code"]) && $_POST["code"] !== ""){
            if($promoDAO->GetPromotion($_POST["code"])->data_seek(0)){
                $this->code = intval(2);
            }
        }

        $TODAY = getdate();
        $year = "$TODAY[year]";

        $this->_TODAY = "$TODAY[year]-$TODAY[month]-$TODAY[mday] $TODAY[hours]:$TODAY[minutes]:$TODAY[seconds]";

        $this->years = array();
        for($i = $year; $i < $year+10; $i++) array_push($this->years, $i);

        $this->months = array();
        for($i = 1; $i <= 12; $i++) array_push($this->months, $i);
    }

    protected function generaCamposFormulario($datos, $errores = array()){

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'card-holder', 'span', array('class' => 'error'));
        $errorCardNumber = self::createMensajeError($errores, 'card-number-0', 'span', array('class' => 'error'));
        $errorCVV = self::createMensajeError($errores, 'card-cvv', 'span', array('class' => 'error'));
        $errorCardExpirationMonth = self::createMensajeError($errores, 'card-expiration-month', 'span', array('class' => 'error'));
        $errorCardExpirationYear = self::createMensajeError($errores, 'card-expiration-year', 'span', array('class' => 'error'));

        $monthsHTML = "";
        foreach($this->months as $value){
            $monthsHTML .= "<option>".$value."</option>";
        }

        $yearsHTML = "";
        foreach($this->years as $value){
            $yearsHTML .= "<option>".$value."</option>";
        }

        if($this->session->getSeatsFull()){
            $html = "<div class='code info'>
                       <h2>La sesión está llena, no quedan asientos disponibles.</h2><hr />
                       <p>Vuelva atrás para selecionar otra sesión.</p>
                    </div>";
        } else {
            if(!empty($this->seat)){
                $seats = "";
                foreach($this->seat as $value){
                    $seats .= $value.", ";
                }

                $promo = "";
                if($this->code > 0) $promo = "<pre>(Se ha aplicado un descuento por código promocional).</pre>";

                $html = "<div class='row'>
                                <fieldset id='datos_entrada'>
                                    <legend>Resumen de la Compra</legend>
                                    <img src='"."../img/films/".$this->film->getImg()."' alt='".$this->film->getTittle()."' />
                                    <p>Película: ".str_replace('_', ' ', strtoupper($this->film->getTittle()))."</p>
                                    <p>Cine: ".$this->cinema->getName()."</p>
                                    <p>Sala: ".$this->session->getIdhall()."</p>
                                    <p>Asiento(s):".$seats."</p>
                                    <p>Fecha: ".date_format(date_create($this->session->getDate()), 'd-m-Y')."</p>
                                    <p>Hora: ".$this->session->getStartTime()."</p>
                                    <p>Precio Total: ".intval($this->session->getSeatPrice()*count($this->seat)-$this->code)."€ (Precio por asiento: ".$this->session->getSeatPrice()." €)</p>
                                    <p>".$promo."</p>
                                </fieldset>
                                <fieldset id='pagar_entrada'><pre>".$htmlErroresGlobales."</pre>
                                    <legend>Datos Bancarios</legend>
                                    <label for='card-holder'>Titular de la Tarjeta:  <span id='cardNameValid'>&#x2714;</span><span id='cardNameInvalid'>&#x274C;</span></label><pre>".$errorNombre."</pre><br />
                                        <input type='text' name='card-holder' id='card-holder' class='card-holder' placeholder='NOMBRE APELLIDO1 APELLIDO2' required />
                                    <br />
                                    <label for='card-number'>Número de Tarjeta: <span id='carNumberValid'>&#x2714;</span><span id='cardNumerInvalid'>&#x274C;</span></label><pre>".$errorCardNumber."</pre><br />
                                        <input type='num' name='card-number-0' id='card-number-0' class='input-cart-number' placeholder='XXXX' maxlength='4' required />
                                        <input type='num' name='card-number-1' id='card-number-1' class='input-cart-number' placeholder='XXXX' maxlength='4' required />
                                        <input type='num' name='card-number-2' id='card-number-2' class='input-cart-number' placeholder='XXXX' maxlength='4' required />
                                        <input type='num' name='card-number-3' id='card-number-3' class='input-cart-number' placeholder='XXXX' maxlength='4' required />    
                                    <label for='card-cvv'>CVV: <span id='cvvValid'>&#x2714;</span><span id='cvvInvalid'>&#x274C;</span></label>
                                        <input type='text' name='card-cvv' id='card-cvv' class='fieldset-cvv' maxlength='3' placeholder='XXX' required /><pre>".$errorCVV."</pre>
                                    <br />
                                    <label for='card-expiration'>Fecha de Expiración: <span id='dateValid'>&#x2714;</span><span id='dateInvalid'>&#x274C;</span></label><pre>".$errorCardExpirationMonth.$errorCardExpirationYear."</pre><br />
                                        <select name='card-expiration-month' id='card-expiration-month' required>
                                        ".$monthsHTML."
                                        </select>
                                        <select name='card-expiration-year' id='card-expiration-year' required>
                                        ".$yearsHTML."
                                        </select>
                                </fieldset>
                                <div class='actions'> 
                                    <input type='hidden' name='sessions' id='sessions' value='".$_POST["sessions"]."' />
                                    <input type='hidden' name='row' id='row' value='".serialize($this->row)."' />
                                    <input type='hidden' name='col' id='col' value='".serialize($this->col)."' />
                                    <input type='submit' id='submit' value='Pagar' class='primary' />
                                    <input type='reset' id='reset' value='Borrar' />       
                                </div>
                            </div>";
            } else {
                $html = "<div class='code info'>
                       <h2>No se ha seleccionado asiento(s).</h2>
                       <p>Vuelva atrás para selecionar una butaca.</p>
                       <button id='go-back'>Volver</button>
                    </div>";
            }
        }
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        
        $nombre = $this->test_input($datos['card-holder']) ?? null;
        $nombre = strtolower($nombre);
        if ( empty($nombre) ) {
            $result['card-holder'] = "El nombre no puede estar vacío.";
        }

        for($i = 0; $i < 4; $i++){
            $card_numer = $this->test_input($datos['card-number-'.$i]) ?? null;
            if ( empty($card_numer) || mb_strlen($card_numer) < 4 ) {
                $result['card-number-0'] = "La tarjeta debe tener 16 dígitos.";
            }
        }

        $cvv = $this->test_input($datos['card-cvv']) ?? null;
        if ( empty($cvv) || mb_strlen($cvv) < 3 ) {
            $result['card-cvv'] = "El CVV debe tener 3 números.";
        }
        
        $month = $this->test_input($datos['card-expiration-month']) ?? null;
        //$TODAY = getdate();
        //$actualMonth = "$TODAY[month]";
        if ( empty($month) /*|| $month < $actualMonth*/) {
            $result['card-expiration-month'] = "El mes de expiración no es correcto.";
        }

        $year = $this->test_input($datos['card-expiration-year']) ?? null;
        if ( empty($year) ) {
            $result['card-expiration-year'] = "El año de expiración no es correcto.";
        }

        if (count($result) === 0) {
           if(isset($_SESSION["login"]) && $_SESSION["login"] == true){
                $purchaseDAO = new PurchaseDAO("complucine");
                $count = count(unserialize($datos["row"]));
                $rows =  unserialize($datos["row"]); $cols =  unserialize($datos["col"]);
                for($i = 0; $i < $count; $i++){
                    if($purchaseDAO->createPurchase(unserialize($_SESSION["user"])->getId(), $this->session->getId(), $this->session->getIdhall(), $this->cinema->getId(), $rows[$i], $cols[$i], date("Y-m-d H:i:s"))){
                        $purchase = new Purchase(unserialize($_SESSION["user"])->getId(), $this->session->getId(), $this->session->getIdhall(), $this->cinema->getId(), $datos["row"], $datos["col"], strftime("%A %e de %B de %Y a las %H:%M"));
                        
                        $_SESSION["purchase"] = serialize($purchase);
                        $_SESSION["film_purchase"] = serialize($this->film);
                        $result = "resume.php";
                    } else {
                        $result[] = "Error al realizar la compra.";
                    }
                }
           } else {
            $purchase = new Purchase("null", $this->session->getId(), $this->session->getIdhall(), $this->cinema->getId(), $datos["row"], $datos["col"], strftime("%A %e de %B de %Y a las %H:%M"));
                $_SESSION["purchase"] = serialize($purchase);
                $_SESSION["film_purchase"] = serialize($this->film);
                $result = "resume.php";
           }
        }

        return $result;
    }
}
?>