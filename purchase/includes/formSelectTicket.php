<?php
include_once($prefix.'assets/php/form.php');
include_once($prefix.'assets/php/includes/session_dao.php');
include_once($prefix.'assets/php/includes/session.php');
include_once($prefix.'assets/php/includes/film_dao.php');
include_once($prefix.'assets/php/includes/film.php');
include_once($prefix.'assets/php/includes/cinema_dao.php');
include_once($prefix.'assets/php/includes/cinema.php');

class FormSelectTicket extends Form {

    public function __construct() {
        parent::__construct('formSelectTicket');
    }

    protected function generaCamposFormulario($datos, $errores = array()){

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        //$errorNombre = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
       
        $html = "";

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