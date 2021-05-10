<?php
require_once('../assets/php/form.php');
include_once('../assets/php/common/user.php');

class FormChangePass extends Form {

    public function __construct() {
        $options = array("action" => "./?option=manage_profile");
        parent::__construct('formChangeUserPass', $options);
    }
    
    protected function generaCamposFormulario($datos, $errores = array()){
        $nombre = $datos['nombreUsuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorOldPass = self::createMensajeError($errores, 'old_pass', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'repass', 'span', array('class' => 'error'));

        $html = "<div class='row'>
                            <fieldset id='contraseña_usuario'><pre>".$htmlErroresGlobales."</pre>
                                <legend>Nueva Contraseña</legend>
                                <input type='password' name='old_pass' id='old_pass' value='' placeholder='Contraseña Actual' required/><pre>".$errorOldPass."</pre>
                                <input type='password' name='pass' id='pass' value='' placeholder='Nueva Contraseña' required/><pre>".$errorPassword."</pre>
                                <input type='password' name='repass' id='repass' value='' placeholder='Repita la nueva contraseña' required/><pre>".$errorPassword2."</pre>
                            </fieldset>
                            <div class='actions'> 
                                <input type='submit' id='submit' value='Cambiar Contraseña' class='primary' />
                                <input type='reset' id='reset' value='Borrar' />       
                            </div>
                        </div>";

        return $html;
    }
    
    /* TODO */
    protected function procesaFormulario($datos){
        $result = array();
        
        $old_pass = $datos['old_pass'] ?? null;
        if ( empty($old_pass) || mb_strlen($old_pass) < 4 ) {
            $result['old_pass'] = "El password tiene que tener\n una longitud de al menos\n 4 caracteres.";
        }
        
        $password = $datos['pass'] ?? null;
        if ( empty($password) || mb_strlen($password) < 4 ) {
            $result['pass'] = "El password tiene que tener una\n longitud de al menos\n 4 caracteres.";
        }
        $password2 = $datos['repass'] ?? null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $result['repass'] = "Los passwords deben coincidir.";
        }
        
        if (count($result) === 0) {
           $bd = new UserDAO("complucine");
           $user = $bd->selectUser(unserialize($_SESSION['user'])->getName(), $old_pass);
           if (!$user) {
                $result[] = "Ha ocurrido un problema\nal actualizar la contraseña.";
                $_SESSION['message'] = "<div class='row'>
                                            <div class='column side'></div>
                                            <div class='column middle'>
                                                <div class='code info'>
                                                    <h1>Ha ocurrido un probrema</h1><hr />
                                                    <p>No hemos podido actualizar su contraseña de usuario, 
                                                    revisa que la contraseña actual sea correcta.</p>
                                                    <a href=''><button>Cerrar Mensaje</button></a>
                                                </div>
                                            </div>
                                            <div class='column side'></div>
                                        </div>
                                        ";
            } else {
                $bd->changeUserPass(unserialize($_SESSION['user'])->getId(), $password);
                $_SESSION['message'] = "<div class='row'>
                                            <div class='column side'></div>
                                            <div class='column middle'>
                                                <div class='code info'>
                                                    <h1>Operacion realizada con exito</h1><hr />
                                                    <p>Se ha modificado su contraseña de usuario correctamente.</p>
                                                    <a href=''><button>Cerrar Mensaje</button></a>
                                                </div>
                                            </div>
                                            <div class='column side'></div>
                                        </div>
                                        ";
                $result = './?option=manage_profile';
            }
        }
        return $result;
    }

    protected function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }
}
?>