<?php
require_once('../assets/php/form.php');
include_once('../assets/php/includes/user.php');
include_once('../assets/php/includes/user_dao.php');

class FormChangeName extends Form {

    public function __construct() {
        $options = array("action" => "./?option=manage_profile");
        parent::__construct('formChangeUserName', $options);
    }
    
    protected function generaCamposFormulario($datos, $errores = array()){
        $nombre = $datos['nombreUsuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'new_name', 'span', array('class' => 'error'));
        $errorNombre2 = self::createMensajeError($errores, 'rename', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));

        $html = "<div class='row'>
                            <fieldset id='nombre_usuario'><pre>".$htmlErroresGlobales."</pre>
                                <legend>Nuevo Nombre de usuario</legend>
                                <input type='text' name='new_name' id='new_name' value='' placeholder='Nuevo Nombre' required/><pre>".$errorNombre."</pre>
                                <span id='userValid'>&#x2714;</span><span id='userWarning'>&#x26a0;</span></span><span id='userInvalid'>&#x274C;</span>
                                <input type='text' name='rename' id='rename' value='' placeholder='Repita el nombre' required/><pre>".$errorNombre2."</pre>
                                <input type='password' name='pass' id='pass' value='' placeholder='Contraseña' required/><pre>".$errorPassword."</pre>
                            </fieldset>
                            <div class='actions'> 
                                <input type='submit' id='submit' value='Cambiar Nombre de Usuario' class='primary' />
                                <input type='reset' id='reset' value='Borrar' />       
                            </div>
                        </div>";

        return $html;
    }
    
    protected function procesaFormulario($datos){
        $result = array();
        
        $nombre = $this->test_input($datos['new_name']) ?? null;
        $nombre = strtolower($nombre);
        if ( empty($nombre) || mb_strlen($nombre) < 3 || mb_strlen($nombre) > 8 ) {
            $result['new_name'] = "El nombre tiene que tener\n una longitud de al menos\n 3 caracteres\n y menos de 8 caracteres.";
        }

        $nombre2 = $this->test_input($datos['rename']) ?? null;
        if ( empty($nombre2) || strcmp($nombre, $nombre2) !== 0 ) {
            $result['rename'] = "Los nombres deben coincidir.";
        }
        
        $password = $this->test_input($datos['pass']) ?? null;
        if ( empty($password) || mb_strlen($password) < 4 ) {
            $result['pass'] = "El password tiene que tener\n una longitud de al menos\n 4 caracteres.";
        }
        
        if (count($result) === 0) {
           $bd = new UserDAO("complucine");
           $user = $bd->selectUser(unserialize($_SESSION['user'])->getName(), $password);
           if (!$user) {
                $result[] = "Ha ocurrido un problema\nal actualizar el nombre de usuario.";
                $_SESSION['message'] = "<div class='row'>
                                            <div class='column side'></div>
                                            <div class='column middle'>
                                                <div class='code info'>
                                                    <h1>Ha ocurrido un probrema</h1><hr />
                                                    <p>No hemos podido actualizar su nombre de usuario. 
                                                    Comprueba que la contraseña introducida sea correcta.</p>
                                                    <a href=''><button>Cerrar Mensaje</button></a>
                                                </div>
                                            </div>
                                            <div class='column side'></div>
                                        </div>
                                        ";
            } else {
                $user = $bd->selectUserName($nombre);
                if ($user->data_seek(0)){
                    $result[] = "El nombre de usuario ya existe.";
                } else {
                    $bd->changeUserName(unserialize($_SESSION['user'])->getId(), $nombre);
                    $user = $bd->selectUser($nombre, $password);
                    $_SESSION['user'] = serialize($user);
                    $_SESSION["nombre"] = $user->getName();
                    $_SESSION['message'] = "<div class='row'>
                                                <div class='column side'></div>
                                                <div class='column middle'>
                                                    <div class='code info'>
                                                        <h1>Operacion realizada con exito</h1><hr />
                                                        <p>Se ha modificado su nombre de usuario correctamente.</p>
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