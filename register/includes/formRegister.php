<?php

include_once($prefix.'login/includes/user_dao.php');
include_once($prefix.'assets/php/form.php');

class FormRegister extends Form {
    //Constants:
    const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

    //Atributes:
    private $user;      // User who is going to log-in.
    private $reply;     // Validation response

    //Constructor:
    public function __construct() {
        parent::__construct('formRegister');
        $this->reply = array();
    }

    //Methods:

    //Returns validation response:
    public function getReply() {
        
        if(isset($_SESSION["login"])){
            $name = strtoupper($_SESSION['nombre']);
            $this->reply = "<h1>Bienvenido {$_SESSION['nombre']}</h1><hr />
                        <p>{$name}, has creado tu cuenta de usuario correctamente.</p>
                        <p>Usa los botones para navegar</p>
                        <a href='../'><button>Inicio</button></a>
                        <a href='../../panel_{$_SESSION["rol"]}'><button>Mi Panel</button></a>\n";
        }   
        else if(!isset($_SESSION["login"])){
            $this->reply = "<h1>ERROR</h1><hr />".
                        "<p>Ha ocurrido un problema y no hemos podido completar el registro.</p>
                        <p>Vuelve a intetarlo o inicia sesión si tienesuna cuenta de usuario.</p>
                        <a href='../login/'><button>Iniciar Sesión</button></a>
                        <form method='post' action='../login/'><button name='register' id='register'>Registro</button></form>\n";
        }

        return $this->reply;
    }

    //Process form:
    public function processesForm($name, $mail, $pass, $repass) {
        $register = true;
        $name = $this->test_input($name);
        $mail = $this->test_input($mail);
        $pass = $this->test_input($pass);
        $repass = $this->test_input($repass);

        $username = isset($name) ? $name : null ;
        if (!$username) {
          $register = false;
        }
        
        $email = isset($mail) ? $mail : null ;
        if (!$email || !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $email)) {
          $register = false;
        }
        
        $password = isset($pass) ? $pass : null ;
        $repassword = isset($repass) ? $repass : null ;
        if($password != $repassword){
            if (!$password || mb_strlen($password) < 4) {
                $register = false;
            }
            if(!$repassword || mb_strlen($repassword) < 4){
                $register = false;
            }
        }
        
        if ($register) {
            $bd = new UserDAO('complucine');
            if($bd){
                $this->user = $bd->selectUser($username, $password);
                try{
                    if (!$this->user) {
                        $bd->createUser("", $username, $email, $password, "user");
                        $this->user = $bd->selectUser($username, $password);
                        if ($this->user) {
                            $_SESSION["nombre"] = $this->user->getName();
                            $_SESSION["rol"] = $this->user->getRol();
                            $_SESSION["login"] = $register;
                        }
                    }
                }
                catch (Exception $e){
                    $_SESSION["login"] = $register;
                }
            }
        }
    }

    protected function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }

}
?>