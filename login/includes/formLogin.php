<?php

include_once('../assets/php/user_dao.php');
include_once('form.php');

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
            $this->reply = "<h1>Bienvenido {$_SESSION['nombre']}</h1><hr />
                                <p>{$_SESSION['nombre']} has iniciado sesión correctamente.</p>
                                <p>Usa los botones para navegar</p>
                                <a href='../'><button>Inicio</button></a>
                                <a href='../../panel_{$_SESSION["rol"]}'><button>Mi Panel</button></a>\n";
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

        $username = isset($name) ? $name : null ;
        if (!$username || !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $username)) {
          $login = false;
        }
        else{
            $login = true;
        }
    
        $password = isset($pass) ? $pass : null ;
        if (!$password || mb_strlen($password) < 4) {
          $login = false;
        }
        else{
            $login = true;
        }
        
        if ($login) {
            $bd = new UserDAO('complucine');
            if($bd){
                $selectUser = $bd->selectUser($username);
                if($selectUser){
                    /*
                    while($row = mysqli_fetch_array($selectUser)){
                        $id = $row['id'];
                        $username = $row['username'];
                        $email = $row['email'];
                        $password = $row['passwd'];
                        $rol = $row['rol'];
                    }
                    $this->user = $bd->loadUser($id, $username, $email, $password, $rol);
                    */
                    //ARREGLAR LO DE ARRIBA Y BORRAR:
                    if($username == "admin") $this->user = $bd->loadUser("0", "admin", "admin@complucine.sytes.net", "adminpass", "admin");
                    else if($username == "manager") $this->user = $bd->loadUser("1", "manager", "manager@complucine.sytes.net", "managerpass", "manager");
                    else $this->user = $bd->loadUser("2", "user", "user@complucine.sytes.net", "userpass", "user");
                }
            }

            if ($this->user->getName()) {
                $_SESSION['user'] = $this->user;
                $_SESSION["nombre"] = $this->user->getName();
                $_SESSION["login"] = $login;
                $_SESSION["rol"] = $this->user->getRol();
            }
        }
        //mysqli_free_result($selectUser);
    }

    protected function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }

    
}
?>