<?php

include_once('../assets/php/common/user_dao.php');
include_once('../assets/php/form.php');

// Class
class FormDeleteAccount extends Form {
    // Constructor
    public function __construct() {
        $options = array("action" => "./?option=delete_user");
        parent::__construct('formDelete', $options);
    }

    // Metodos
    // Generar formulario
    protected function generaCamposFormulario($datos, $errores = array()){
        $nombre = $datos['nombreUsuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));

        $html = "<div class='row'>
                            <fieldset id='contraseña_usuario'><pre>".$htmlErroresGlobales."</pre>
                                <legend>Eliminar usuario</legend>
                                <input type='password' name='pass' id='pass' value='' placeholder='Contraseña actual' required/><pre>".$errorPassword."</pre>                            </fieldset>
                            <div class='actions'> 
                                <input type='submit' id='submit' value='Borrar cuenta' class='primary' onclick=\"return confirm('¿Estás seguro? Se borrará la cuenta definitivamente.');\"/>
                                <input type='reset' id='reset' value='Borrar' />       
                            </div>
                        </div>";

        return $html;
    }

    // Procesar el formulario
    protected function procesaFormulario($datos){
        $result = array();
        
        $password = $datos['pass'] ?? null;
        if ( empty($password) || mb_strlen($password) < 4 ) {
            $result['pass'] = "Vuelve a introducir tu contrseña.";
        }
        
        if (count($result) === 0) {
           $bd = new UserDAO("complucine");
           $user = $bd->selectUser(unserialize($_SESSION['user'])->getName(), $password);
           if (!$user) {
                $result[] = "Ha ocurrido un problema\nal eliminar el usuario.";
                $_SESSION['message'] = "<div class='row'>
                                            <div class='column side'></div>
                                            <div class='column middle'>
                                                <div class='code info'>
                                                    <h1>Ha ocurrido un problema</h1><hr />
                                                    <p>No se ha podido eliminar el usuario. 
                                                    Comprueba que la contraseña introducida sea correcta.</p>
                                                    <a href=''><button>Cerrar Mensaje</button></a>
                                                </div>
                                            </div>
                                            <div class='column side'></div>
                                        </div>
                                        ";
            }
            else {
                $bd->deleteUser(unserialize($_SESSION['user'])->getId());
                $_SESSION['message'] = "<div class='row'>
                                            <div class='column side'></div>
                                            <div class='column middle'>
                                                <div class='code info'>
                                                    <h1>Operacion realizada con exito</h1><hr />
                                                    <p>Se ha eliminado su usuario correctamente.</p>
                                                    <a href=''><button>Cerrar Mensaje</button></a>
                                                </div>
                                            </div>
                                            <div class='column side'></div>
                                        </div>
                                        ";
                $result = '/logout/index.php';
            }
        }
        return $result;
    }

    protected function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }
}
?>