<?php
require_once('../assets/php/form.php');
include_once('../assets/php/common/user.php');
include_once('../assets/php/common/user_dao.php');

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
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'repass', 'span', array('class' => 'error'));

        $html = "<div class='row'>".$htmlErroresGlobales."
                            <fieldset id='nombre_usuario'>
                                <legend>Nuevo Nombre de usuario</legend>
                                <div class='_new_name'>
                                    <input type='text' name='new_name' id='new_name' value='' placeholder='Nuevo Nombre' required/><pre>".$errorNombre."</pre>
                                </div>
                                <div class='_passwd'>
                                    <input type='password' name='pass' id='pass' value='' placeholder='Contraseña' required/><pre>".$errorPassword."</pre>
                                </div>
                                <div class='_passwd'>
                                    <input type='password' name='repass' id='repass' value='' placeholder='Repita la contraseña' required/><pre>".$errorPassword2."</pre>
                                </div>
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
        
        $nombre = $datos['new_name'] ?? null;
        $nombre = strtolower($nombre);
        if ( empty($nombre) || mb_strlen($nombre) < 3 ) {
            $result['new_name'] = "El nombre tiene que tener una longitud de al menos 3 caracteres.";
        }
        
        $password = $datos['pass'] ?? null;
        if ( empty($password) || mb_strlen($password) < 4 ) {
            $result['pass'] = "El password tiene que tener una longitud de al menos 4 caracteres.";
        }
        $password2 = $datos['repass'] ?? null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $result['repass'] = "Los passwords deben coincidir.";
        }
        
        if (count($result) === 0) {
           $bd = new UserDAO("complucine");
           $user = $bd->selectUser(unserialize($_SESSION['user'])->getName(), $password);
           if (!$user) {
            $result[] = "Ha ocurrido un probrema al actualizar el nombre de usuario.";
            $_SESSION['message'] = "<div class='row'>
                                        <div class='column side'></div>
                                        <div class='column middle'>
                                            <div class='code info'>
                                                <h1>Ha ocurrido un probrema</h1><hr />
                                                <p>No hemos podido actualizar su nombre de usuario.</p>
                                                <a href=''><button>Cerrar Mensaje</button></a>
                                            </div>
                                        </div>
                                        <div class='column side'></div>
                                    </div>
                                    ";
        } else {
            $bd->changeUserName(unserialize($_SESSION['user'])->getId(), $nombre);
            $user = $bd->selectUser($nombre, $password);
            if (!$user){
                $result[] = "Ha ocurrido un probrema al actualizar el nombre de usuario.";
            }else{
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

    protected function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }
}
?>