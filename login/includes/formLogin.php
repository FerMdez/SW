<?php

include_once($prefix.'assets/php/common/user_dao.php');
include_once($prefix.'assets/php/form.php');

class FormLogin extends Form {
    //Constants:
    const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

    //Atributes:
    private $user;  // User who is going to log-in.
    private $reply; // Validation response

    //Constructor:
    public function __construct() {
        parent::__construct('formLogin');
        $this->reply = array();
    }

    //Methods:

    //Returns validation response:
    public function getReply() {
        
        if(isset($_SESSION["login"])){
            $name = strtoupper($_SESSION['nombre']);
            $this->reply = "<h1>Bienvenido {$name}</h1><hr />
                        <p>{$name}, has iniciado sesión correctamente.</p>
                        <p>Usa los botones para navegar</p>
                        <a href='../'><button>Inicio</button></a>
                        <a href='../panel_{$_SESSION["rol"]}'><button>Mi Panel</button></a>\n";
        }   
        else if(!isset($_SESSION["login"])){
            $this->reply = "<h1>ERROR</h1><hr />".
                        "<p>El usuario o contraseña no son válidos.</p>
                        <p>Vuelve a intetarlo o regístrate si no lo habías hecho previamente.</p>
                        <a href='./'><button>Iniciar Sesión</button></a>
                        <form method='post' action='./'><button name='register' id='register'>Registro</button></form>\n";
        }

        return $this->reply;
    }

    //Process form:
    public function processesForm($name, $pass) {
        $login = true;
        $name = $this->test_input($name); 
        $pass = $this->test_input($pass);

        $name = strtolower($name);
        $username = isset($name) ? $name : null ;
        if (!$username) {
          $login = false;
        }
        
        /*
        $email = isset($mail) ? $mail : null ;
        if (!$email || !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $email)) {
          $login = false;
        }
        */
    
        $password = isset($pass) ? $pass : null ;
        if (!$password || mb_strlen($password) < 4) {
          $login = false;
        }
        
        if ($login) {
            $bd = new UserDAO('complucine');
            if($bd){
                $this->user = $bd->selectUser($username, $password);

                try{
                    if ($this->user) {
                        $this->user->setPass(null);
                        $_SESSION["user"] = serialize($this->user);
                        $_SESSION["nombre"] = $this->user->getName();
                        $_SESSION["rol"] = $this->user->getRol();
                        $_SESSION["login"] = $login;
                    }
                }
                catch (Exception $e){
                    $_SESSION["login"] = $login;
                }
            }

        }

    }

    protected function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }

}
?>