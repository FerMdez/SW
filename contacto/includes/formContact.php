<?php
require_once($prefix.'assets/php/form.php');
require_once($prefix.'assets/php/includes/user.php');

class FormContact extends Form {
    //Constants:
    const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

    public function __construct() {
        $options = array("action" => "");
        parent::__construct('formContact', $options);
    }
    
    protected function generaCamposFormulario($datos, $errores = array()) {
        if(isset($_SESSION["user"])){ $nameValue = "value=".unserialize($_SESSION['user'])->getName().""; $emailValue = "value=".unserialize($_SESSION['user'])->getEmail().""; }
        else { $nameValue = "placeholder='Nombre'"; $emailValue = "placeholder='Email'"; }

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorEmail = self::createMensajeError($errores, 'email', 'span', array('class' => 'error'));
        $errorMessage = self::createMensajeError($errores, 'message', 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = "<div class='row'>
                    <fieldset id='datos_personales'>
                        <legend>Datos personales</legend><pre>".$htmlErroresGlobales."</pre>
                        <div class='_name'>
                            <input type='text' name='name' id='name' ".$nameValue." required/><pre>".$errorNombre."</pre>
                        </div>
                        <div class='_email'>
                            <input type='email' name='email' id='email' ".$emailValue." required/><pre>".$errorEmail."</pre>
                        </div>
                    </fieldset>
                    <fieldset id='motivo'>
                        <legend>Motivo de la consulta</legend>
                        <div class='reason'>
                            <input type='radio' id='radio' name='reason' value='evaluation' checked>
                            <label for='evaluation'>Evaluación</label>
                        </div>
                        <div class='reason'>
                            <input type='radio' id='radio' name='reason' value='sugestions'>
                            <label for='sugestions'>Sugerencias</label>
                        </div>
                        <div class='reason'>
                            <input type='radio' id='radio' name='reason' value='critics'>
                            <label for='critics'>Críticas</label>
                        </div>
                    </fieldset>
                    <div class='message'><pre>".$errorMessage."</pre>
                        <textarea name='message' id='message' placeholder='Escribe aquí tu mensaje...'></textarea>
                    </div>
                    <div class='verify'>
                        <input type='checkbox' id='checkbox' name='terms' required>
                        <label for='terms'>Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio.</label>
                    </div>
                    <div class='actions'> 
                        <input type='submit' id='submit' value='Enviar mensaje' class='primary' />
                        <input type='reset' id='reset' value='Borrar' />       
                    </div>
                </div>";

        return $html;
    }
    

    protected function procesaFormulario($datos) {
        $result = array();

        $nombre = $this->test_input($datos['name']) ?? null;
        if ( empty($nombre) || mb_strlen($nombre) < 3 || mb_strlen($nombre) > 15 ) {
            $result['name'] = "El nombre tiene que tener\n una longitud de más de\n 3 caracteres\n y menos de 15 caracteres.";
        }
        
        $email = $this->test_input($datos['email']) ?? null;
        if ( empty($email) || !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $email) ) {
            $result['email'] = "El email no es válido.";
        }

        $message = $this->test_input($datos['message']) ?? null;
        if ( empty($message) || mb_strlen($message) < 1 || mb_strlen($message) > 250 ) {
            $result['message'] = "El mensaje no puede estar vacío\ny no puede contener más de\n250 caracteres.";
        }

        if (count($result) === 0) {
            $result = ROUTE_APP;  // DE MOMENTO, NO HACE NADA :)      
        }
        
        return $result;
    }
}
?>