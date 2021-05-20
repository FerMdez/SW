<?php
require_once('../assets/php/form.php');
include_once('../assets/php/includes/user.php');

class FormChangeEmail extends Form {
    //Constants:
    const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

    public function __construct() {
        $options = array("action" => "./?option=manage_profile");
        parent::__construct('formChangeUserEmail', $options);
    }
    
    protected function generaCamposFormulario($datos, $errores = array()){
        $email = $datos['email'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorEmail = self::createMensajeError($errores, 'new_email', 'span', array('class' => 'error'));
        $errorEmail2 = self::createMensajeError($errores, 'remail', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));

        $html = "<div class='row'>
                            <fieldset id='email_usuario'><pre>".$htmlErroresGlobales."</pre>
                                <legend>Nuevo email de usuario</legend>
                                <input type='text' name='new_email' id='new_email' value='' placeholder='Nuevo Email' required/><pre>".$errorEmail."</pre>
                                <span id='emailValid'>&#x2714;</span></span><span id='emailInvalid'>&#x274C;</span>
                                <input type='text' name='remail' id='remail' value='' placeholder='Repita el email' required/><pre>".$errorEmail2."</pre>
                                <input type='password' name='pass' id='pass' value='' placeholder='Contraseña' required/><pre>".$errorPassword."</pre>
                            </fieldset>
                            <div class='actions'> 
                                <input type='submit' id='submit' value='Cambiar Email de Usuario' class='primary' />
                                <input type='reset' id='reset' value='Borrar' />       
                            </div>
                        </div>";

        return $html;
    }
    
    protected function procesaFormulario($datos){
        $result = array();
        
        $email = $this->test_input($datos['new_email']) ?? null;
        if ( empty($email) || !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $email) ) {
            $result['new_email'] = "El nuevo email no es válido.";
        }

        $email2 = $this->test_input($datos['remail']) ?? null;
        if ( empty($email2) || strcmp($email, $email2) !== 0 ) {
            $result['remail'] = "Los emails deben coincidir";
        }
        
        $password = $this->test_input($datos['pass']) ?? null;
        if ( empty($password) || mb_strlen($password) < 4 ) {
            $result['pass'] = "El password tiene que tener\n una longitud de al menos\n 4 caracteres.";
        }
        
        if (count($result) === 0) {
           $bd = new UserDAO("complucine");
           $user = $bd->selectUser(unserialize($_SESSION['user'])->getName(), $password);
           if (!$user) {
            $result[] = "El usuario no existe.";
            $_SESSION['message'] = "<div class='row'>
                                        <div class='column side'></div>
                                        <div class='column middle'>
                                            <div class='code info'>
                                                <h1>Ha ocurrido un probrema</h1><hr />
                                                <p>No hemos podido actualizar su email de usuario.
                                                Comprueba que la contraseña introducida sea correcta.</p>
                                                <a href=''><button>Cerrar Mensaje</button></a>
                                            </div>
                                        </div>
                                        <div class='column side'></div>
                                    </div>
                                    ";
            } else {
                $user = $bd->selectUserEmail($email);
                if ($user->data_seek(0)){
                    $result[] = "El email ya está registrado.";
                } else {
                    $bd->changeUserEmail(unserialize($_SESSION['user'])->getId(), $email);
                    $user = $bd->selectUser(unserialize($_SESSION['user'])->getName(), $password);
                    $_SESSION['user'] = serialize($user);
                    $_SESSION["nombre"] = $user->getName();
                    $_SESSION['message'] = "<div class='row'>
                                                <div class='column side'></div>
                                                <div class='column middle'>
                                                    <div class='code info'>
                                                        <h1>Operacion realizada con exito</h1><hr />
                                                        <p>Se ha modificado su email correctamente.</p>
                                                        <a href=''><button>Cerrar Mensaje</button></a>
                                                    </div>
                                                </div>
                                                <div class='column side'></div>
                                            </div>
                                            ";
                    $result = './?option=manage_profile';
                }
            }
        }
        return $result;
    }
}
?>