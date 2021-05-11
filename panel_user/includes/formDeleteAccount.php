<?php
require_once('../assets/php/form.php');
include_once('../assets/php/common/user.php');
include_once('../assets/php/common/user_dao.php');

class FormDeleteAccount extends Form {
     //Constants:
     const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

    public function __construct() {
        $options = array("action" => "./?option=delete_user");
        parent::__construct('formDeleteAccount', $options);
    }
    
    protected function generaCamposFormulario($datos, $errores = array()){
        $nombre = $datos['username'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'new_name', 'span', array('class' => 'error'));
        $errorEmail = self::createMensajeError($errores, 'email', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'repass', 'span', array('class' => 'error'));

        $html = "<div class='row'>
                            <fieldset id='cuenta_usuario'><pre>".$htmlErroresGlobales."</pre>
                                <legend>Datos de la cuenta</legend>
                                <input type='text' name='name' id='name' value='' placeholder='Nombre de usuario' required/><pre>".$errorNombre."</pre>
                                <input type='text' name='email' id='email' value='' placeholder='Email de usuario' required/><pre>".$errorEmail."</pre>
                                <input type='password' name='pass' id='pass' value='' placeholder='Contraseña' required/><pre>".$errorPassword."</pre>
                                <input type='password' name='repass' id='repass' value='' placeholder='Repita la contraseña' required/><pre>".$errorPassword2."</pre>
                            </fieldset>
                            <div class='verify'>
                                <input type='checkbox' id='checkbox' name='verify' required>
                                <label for='verify'>Marque esta casilla para confirmar que entiende que esta acción no se puede deshacer.</label>
                            </div>
                            <div class='actions'> 
                                <input type='submit' id='submit' value='Eliminar Cuenta de Usuario' class='primary' />
                                <input type='reset' id='reset' value='Borrar' />       
                            </div>
                        </div>";

        return $html;
    }
    
    protected function procesaFormulario($datos){
        $result = array();
        
        $nombre = $datos['name'] ?? null;
        $nombre = strtolower($nombre);
        if ( empty($nombre) || mb_strlen($nombre) < 3 || mb_strlen($nombre) > 8 ) {
            $result['new_name'] = "El nombre tiene que tener\n una longitud de al menos\n 3 caracteres\n y menos de 8 caracteres.";
        }

        $email = $datos['email'] ?? null;
        if ( empty($email) || !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $email) ) {
            $result['email'] = "El email no es válido.";
        }
        
        $password = $datos['pass'] ?? null;
        if ( empty($password) || mb_strlen($password) < 4 ) {
            $result['pass'] = "El password tiene que tener\n una longitud de al menos\n 4 caracteres.";
        }
        $password2 = $datos['repass'] ?? null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $result['repass'] = "Los passwords deben coincidir.";
        }
        
        if (count($result) === 0) {
           $bd = new UserDAO("complucine");
           $user = $bd->selectUser($nombre, $password);
           if (!$user) {
                $result[] = "El usuario o contraseña\nno son correctos.";
            } else {
                if( (unserialize($_SESSION['user'])->getId() === $user->getId()) && ($nombre === $user->getName())
                        && ($email === $user->getEmail()) && ($bd->verifyPass($password, $user->getPass())) ){

                    $bd->deleteUserAccount($user->getId());
                    unset($_SESSION);
                    session_destroy();

                    $result = ROUTE_APP;
                } else {
                    $result[] = "Los datos introducidos\nno son válidos.";
                }
            }
        }
        return $result;
    }

    protected function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }
}
?>