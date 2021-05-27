<?php

include_once($prefix.'assets/php/includes/user_dao.php');
include_once($prefix.'assets/php/form.php');

class FormLogin extends Form {
    //Constants:
    const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

    //Atributes:
    private $user;  // User who is going to log-in.

    public function __construct() {
        parent::__construct('formLogin');
    }

    protected function generaCamposFormulario($datos, $errores = array()){
        $nombre = $datos['name'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'pass', 'span', array('class' => 'error'));

        $html = "<div class='row'>
                            <fieldset id='nombre_usuario'><pre>".$htmlErroresGlobales."</pre>
                                <legend>Datos Personales</legend>
                                <input type='text' name='name' id='name' value='' placeholder='Nombre de Usuario' required/><pre>".$errorNombre."</pre>
                                <input type='password' name='pass' id='pass' value='' placeholder='Contraseña' required/><pre>".$errorPassword."</pre>
                            </fieldset>
                            <div class='actions'> 
                                <input type='submit' id='submit' value='Iniciar Sesión' class='primary' />
                                <input type='reset' id='reset' value='Borrar' />       
                            </div>
                        </div>";

        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        
        $nombre = $this->test_input($datos['name']) ?? null;
        //$nombre = $datos['name'] ?? null;
        $nombre = strtolower($nombre);
        if ( empty($nombre) || mb_strlen($nombre) < 3 || mb_strlen($nombre) > 15 ) {
            $result['name'] = "El nombre tiene que tener\n una longitud de al menos\n 3 caracteres\n y menos de 15 caracteres.";
        }
        
        $password = $this->test_input($datos['pass']) ?? null;
        //$password = $datos['pass'] ?? null;
        if ( empty($password) || mb_strlen($password) < 4 ) {
            $result['pass'] = "El password tiene que tener\n una longitud de al menos\n 4 caracteres.";
        }
        
        if (count($result) === 0) {
            $bd = new UserDAO('complucine');
            if($bd){
                $this->user = $bd->selectUser($nombre, $password);
                if ($this->user) {
                    $this->user->setPass(null);
                    $_SESSION["user"] = serialize($this->user);
                    $_SESSION["nombre"] = $this->user->getName();
                    $_SESSION["rol"] = $this->user->getRol();
                    $_SESSION["login"] = true;
                    $result = 'validate.php';
                } else {
                    $result[] = "El usuario o el password\nno coinciden.";
                }
            } else {
                $result[] = "Error al conectar con la BD.";
            }
        }

        return $result;
    }

    //Returns validation response:
    static public function getReply() {
        
        if(isset($_SESSION["login"])){
            $name = strtoupper($_SESSION['nombre']);
            $reply = "<h1>Bienvenido {$name}</h1><hr />
                        <p>{$name}, has iniciado sesión correctamente.</p>
                        <p>Usa los botones para navegar</p>
                        <a href='../'><button>Inicio</button></a>
                        <a href='../panel_{$_SESSION["rol"]}'><button>Mi Panel</button></a>\n";
        }   
        else if(!isset($_SESSION["login"])){
            $reply = "<h1>ERROR</h1><hr />".
                        "<p>El usuario o contraseña no son válidos.</p>
                        <p>Vuelve a intetarlo o regístrate si no lo habías hecho previamente.</p>
                        <a href='./'><button>Iniciar Sesión</button></a>
                        <form method='post' action='./'><button name='register' id='register'>Registro</button></form>\n";
        }

        return $reply;
    }
}
?>