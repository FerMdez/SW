<?php
require_once('../assets/php/form.php');
include_once('../assets/php/includes/user.php');

class FormChangePass extends Form {
    //Constants:
    const HTML5_PASS_REGEXP = '^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{4,16}$';

    public function __construct() {
        $options = array("action" => "./?option=manage_profile");
        parent::__construct('formChangeUserPass', $options);
    }
    
    protected function generaCamposFormulario($datos, $errores = array()){

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorOldPass = self::createMensajeError($errores, 'old_pass', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'new_pass', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'repass', 'span', array('class' => 'error'));

        $html = "<div class='row'>
                        <fieldset id='contraseña_usuario'><pre>".$htmlErroresGlobales."</pre>
                            <legend>Nueva Contraseña</legend>
                            <input type='password' name='old_pass' id='old_pass' value='' placeholder='Contraseña Actual' required/><pre>".$errorOldPass."</pre>
                            <input type='password' name='new_pass' id='new_pass' value='' placeholder='Nueva Contraseña' required/><pre>".$errorPassword."</pre>
                            <span id='passValid'>&#x2714;</span><span id='passWarning'>&#x26a0;</span></span><span id='passInvalid'>&#x274C;</span>
                            <input type='password' name='repass' id='repass' value='' placeholder='Repita la nueva contraseña' required/><pre>".$errorPassword2."</pre>
                            <span id='repassValid'>&#x2714;</span></span><span id='repassInvalid'>&#x274C;</span>
                        </fieldset>
                        <div class='actions'> 
                            <input type='submit' id='submit' value='Cambiar Contraseña' class='primary' />
                            <input type='reset' id='reset' value='Borrar' />       
                        </div>
                    </div>";

        return $html;
    }
    
    protected function procesaFormulario($datos){
        $result = array();
        
        $old_pass = $this->test_input($datos['old_pass']) ?? null;
        if ( empty($old_pass) || mb_strlen($old_pass) < 4 ) {
            $result['old_pass'] = "El password tiene que tener\n una longitud de al menos\n 4 caracteres.";
        }
        
        $password = $this->test_input($datos['new_pass']) ?? null;
        if ( empty($password) || !mb_ereg_match(self::HTML5_PASS_REGEXP, $password) ) {
            $result['new_pass'] = "El password tiene que tener\n una longitud de al menos\n 4 caracteres 1 mayúscula y 1 número.";
        }
        $password2 = $this->test_input($datos['repass']) ?? null;
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
                                                    <p>No hemos podido actualizar su contraseña de usuario. 
                                                    Comprueba que la contraseña actual sea correcta.</p>
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
}
?>