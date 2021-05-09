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
        $errorNombre = self::createMensajeError($errores, 'nombre', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'repass', 'span', array('class' => 'error'));

        $html = '<div class="row">'.$htmlErroresGlobales.'
                            <fieldset id="contraseña_usuario">
                                <legend>Contraseña Actual</legend>
                                <div class="_passwd">
                                    <input type="password" name="old_pass" id="old_pass" value="" placeholder="Contraseña Actual" required/>
                                </div>
                                <div class="_passwd">
                                    <input type="password" name="pass" id="pass" value="" placeholder="Nueva Contraseña" required/>
                                </div>
                                <div class="_passwd">
                                    <input type="password" name="repass" id="repass" value="" placeholder="Repita la nueva contraseña" required/>
                                </div>
                            </fieldset>
                            <div class="actions"> 
                                <input type="submit" id="submit" value="Cambiar Contraseña" class="primary" />
                                <input type="reset" id="reset" value="Borrar" />       
                            </div>
                        </div>';

        return $html;
    }
    
    /* TODO */
    protected function procesaFormulario($datos){
        $result = array();
        
        $old_pass = $datos['old_pass'] ?? null;
        if ( empty($old_pass) || mb_strlen($old_pass) < 5 ) {
            $result['old_pass'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $password = $datos['pass'] ?? null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $result['pass'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = $datos['repass'] ?? null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $result['repass'] = "Los passwords deben coincidir.";
        }
        
        if (count($result) === 0) {
           $bd = new UserDAO("complucine");
           $user = $bd->selectUser(unserialize($_SESSION['user'])->getName(), $password);
           if (!$user) {
            $result[] = "El usuario no existe.";
        } else {
            //$bd->changeUserName(unserialize($_SESSION['user'])->getId(), $username);
            $user = $bd->selectUser($username, $password);
            if (!$user){
                $result[] = "Ha ocurrido un probrema al actualizar contraseña.";
            }else{
                $_SESSION['message'] = "<div class='row'>
                                            <div class='column side'></div>
                                            <div class='column middle'>
                                                <div class='code info'>
                                                    <h1>Operacion realizada con exito</h1><hr />
                                                    <p>Se ha modificado su contraseña correctamente.</p>
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