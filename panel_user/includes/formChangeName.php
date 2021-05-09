<?php
require_once('../assets/php/form.php');
include_once('../assets/php/common/user.php');

class FormChangeName extends Form {

    public function __construct() {
        $options = array("action" => "./?option=manage_profile");
        parent::__construct('formChangeUserName', $options);
    }
    
    protected function generaCamposFormulario($datos, $errores = array()){
        $nombre = $datos['nombreUsuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'nombre', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'repass', 'span', array('class' => 'error'));

        $html = '<div class="row">'.$htmlErroresGlobales.'
                    <fieldset id="nombre_usuario">
                        <legend>Nuevo Nombre de usuario</legend>
                        <div class="_new_name">
                            <input type="text" name="new_name" id="new_name" value="" placeholder="Nuevo Nombre" required/>
                        </div>
                        <div class="_passwd">
                            <input type="password" name="pass" id="pass" value="" placeholder="Contraseña" required/>
                        </div>
                        <div class="_passwd">
                            <input type="password" name="repass" id="repass" value="" placeholder="Repita la contraseña" required/>
                        </div>
                    </fieldset>
                    <div class="actions"> 
                        <input type="submit" id="submit" value="Cambiar Nombre de Usuario" class="primary" />
                        <input type="reset" id="reset" value="Borrar" />       
                    </div>
                </div>';

        return $html;
    }
    
    protected function procesaFormulario($datos){
        $result = array();
        
        $nombre = $datos['new_name'] ?? null;
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
            $result['new_name'] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $password = $datos['pass'] ?? null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $result['pass'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = $datos['repass'] ?? null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $result['repass'] = "Los passwords deben coincidir";
        }
        
        if (count($result) === 0) {
           $bd = new UserDAO("complucine");
           $user = $bd->selectUser(unserialize($_SESSION['user'])->getName(), $password);
           if (!$user) {
            $result[] = "El usuario no existe.";
        } else {
            $bd->changeUserName(unserialize($_SESSION['user'])->getId(), $username);
            $user = $bd->selectUser($username, $password);
            if (!$user){
                $result[] = "Ha ocurrido un probrema al actualizar el nombre de usuario.";
            }else{
                $_SESSION['user'] = serialize($user);
                $_SESSION["nombre"] = $user->getName();
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