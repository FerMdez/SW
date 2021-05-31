<?php
include_once($prefix.'assets/php/includes/user_dao.php');
include_once($prefix.'assets/php/form.php');

class FormRegister extends Form {
    //Constants:
    const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';
    const HTML5_PASS_REGEXP = '^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{4,16}$';

    //Atributes:
    private $user;      // User who is going to log-in.

    //Constructor:
    public function __construct() {
        parent::__construct('formRegister');
    }

    //Methods:

    protected function generaCamposFormulario($datos, $errores = array()){
        //$nombre = $datos['new_name'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'new_name', 'span', array('class' => 'error'));
        $errorEmail = self::createMensajeError($errores, 'new_email', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'new_pass', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'repass', 'span', array('class' => 'error'));

        $html = "<div class='row'>
                            <fieldset id='datos_personales'><pre>".$htmlErroresGlobales."</pre>
                                <legend>Datos personales</legend>
                                <input type='text' name='new_name' id='new_name' value='' placeholder='Nombre de Usuario' required/><pre>".$errorNombre."</pre>
                                <span id='userValid'>&#x2714;</span><span id='userWarning'>&#x26a0;</span></span><span id='userInvalid'>&#x274C;</span>
                                <input type='email' name='new_email' id='new_email' value='' placeholder='Email' required/><pre>".$errorEmail."</pre>
                                <span id='emailValid'>&#x2714;</span></span><span id='emailInvalid'>&#x274C;</span>
                                <input type='password' name='new_pass' id='new_pass' value='' placeholder='Contraseña' required/><pre>".$errorPassword."</pre>
                                <span id='passValid'>&#x2714;</span><span id='passWarning'>&#x26a0;</span></span><span id='passInvalid'>&#x274C;</span>
                                <input type='password' name='repass' id='repass' value='' placeholder='Repita la contraseña' required/><pre>".$errorPassword2."</pre>
                                <span id='repassValid'>&#x2714;</span></span><span id='repassInvalid'>&#x274C;</span>
                            </fieldset>
                            <div class='verify'>
                                <input type='checkbox' id='checkbox' name='terms' required>
                                <label for='terms'><a href ='../fdicines/terms_conditions/' target='_blank'>Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio.</a></label>
                            </div>
                            <div class='actions'> 
                                <input  type='submit' name='register' id='register' value='Registrarse' class='primary' />
                                <input type='reset' id='reset' value='Borrar' />       
                            </div>
                        </div>";

        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        
        $nombre = $this->test_input($datos['new_name']) ?? null;
        $nombre = strtolower($nombre);
        if ( empty($nombre) || mb_strlen($nombre) < 3 || mb_strlen($nombre) > 15 ) {
            $result['new_name'] = "El nombre tiene que tener\n una longitud de al menos\n 3 caracteres\n y menos de 15 caracteres.";
        }

        $email = $this->test_input($datos['new_email']) ?? null;
        if ( empty($email) || !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $email) ) {
            $result['new_email'] = "El email no es válido.";
        }
        
        $password = $this->test_input($datos['new_pass']) ?? null;
        if ( empty($password) || !mb_ereg_match(self::HTML5_PASS_REGEXP, $password) ) {
            $result['new_pass'] = "El password tiene que tener\n una longitud de al menos\n 4 caracteres 1 mayúscula y 1 número.";
        }
        $password2 = $this->test_input($datos['repass']) ?? null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $result['repass'] = "Los passwords deben coincidir";
        }
        
        if (count($result) === 0) {
            $bd = new UserDAO('complucine');
            if($bd){
                $this->user = $bd->selectUserName($nombre);
                if ($this->user->data_seek(0)) {
                    $result[] = "El usuario ya existe.";
                }
                else{
                    $this->user = $bd->selectUserEmail($email);
                    if ($this->user->data_seek(0)) {
                        $result[] = "El email ya está registrado.";
                    } else {
                        $bd->createUser("", $nombre, $email, $password, "user");
                        $this->user = $bd->selectUser($nombre, $password);
                        if ($this->user) {
                            $this->user->setPass(null);
                            $_SESSION["user"] = serialize($this->user);
                            $_SESSION["nombre"] = $this->user->getName();
                            $_SESSION["rol"] = $this->user->getRol();
                            $_SESSION["login"] = true;
                            $img = "../img/users/user.jpg"; //USER_PICS
                            $profile_img = "../img/users/".$nombre.".jpg";
                            copy($img, $profile_img);
                            $result = ROUTE_APP."register/register.php";
                        }
                    }
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
            $reply = "<h1>Bienvenido {$_SESSION['nombre']}</h1><hr />
                        <p>{$name}, has creado tu cuenta de usuario correctamente.</p>
                        <p>Usa los botones para navegar</p>
                        <a href='../'><button>Inicio</button></a>
                        <a href='../../panel_{$_SESSION["rol"]}'><button>Mi Panel</button></a>\n";
        }   
        else if(!isset($_SESSION["login"])){
            $reply = "<h1>ERROR</h1><hr />
                        <p>Ha ocurrido un problema y no hemos podido completar el registro</p>
                        <p>Vuelve a intetarlo o inicia sesión si tienes una cuenta de usuario.</p>
                        <a href='../login/'><button>Iniciar Sesión</button></a>
                        <form method='post' action='../login/'><button name='register' id='_register'>Registro</button></form>\n";
        }

        return $reply;
    }

}
?>