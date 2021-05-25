<?php
include_once($prefix.'assets/php/form.php');
//include_once($prefix.'assets/php/includes/session_dao.php');
include_once($prefix.'assets/php/includes/session.php');

class FormPurchase extends Form {

    //Atributes:
    private $user;  // User who is going to log-in.

    public function __construct() {
        parent::__construct('formPurchase');
    }

    protected function generaCamposFormulario($datos, $errores = array()){

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));

        $html = "<div class='row'>
                            <fieldset id='pagar_entrada'><pre>".$htmlErroresGlobales."</pre>
                                <legend>Resumen de la Compra</legend>
                                <p>Película: ".$session->getIdfilm()."</p>
                                <p>Cine: ".$session->getIdcinema()."</p>
                                <p>Sala: ".$session->getIdhall()."</p>
                                <p>Fecha: ".date_format(date_create($session->getDate()), 'd-m-Y')."</p>
                                <p>Hora: ".$session->getStartTime()."</p>
                                <p>Precio: ".$session->getSeatPrice()."€</p>
                                <legend>Datos Bancarios</legend>
                                <input type='text' name='account' id='account' value='' placeholder='Cuenta Bancaria [En desarrollo...]' required/><pre>".$errorNombre."</pre>
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