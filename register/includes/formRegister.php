<?php
    require_once('user_dao.php');
?>

<?php
    class Register {
        // ATRIBUTOS
        private $name;
        private $email;
        private $password;
        private $repassword;
        private $rol; // Desde aqui solo se registran usuarios finales, seran rol "user"
        private $id; // Generado en la BD? Aleatorio?
        private $reply;

        // CONSTRUCTOR
        function __construct() {}

        // METODOS
        public function testReg() {
            $this->name = $this->test_input($_POST["name"]);
            $this->email = $this->test_input($_POST["email"]);
            $this->password = $this->test_input($_POST["pass"]);
            $this->repassword = $this->test_input($_POST["repass"]);
            $this->rol = "user";
            $this->id = "xxxx";

            // Creamos DAO
            $instanceDAO = new UserDAO('complucine');

            // Creamos DTO
            $uDTO = $instanceDAO->loadUser($this->id, $this->name, $this->email, $this->password, $this->rol);

            if($this->password == $this->repassword) { // Comprobacion de contrasenyas iguales
                $resultado = $instanceDAO->selectUser($uDTO->getName());
                if($resultado->num_rows == 0) { // Comprobacion de que el usuario no existe ya en la BD
                    // Se manda el usuario al DAO, que lo creara en la BD
                    $instanceDAO->createUser($uDTO->getId(), $uDTO->getName(), $uDTO->getEmail(), $uDTO->getPass(), $uDTO->getRol());
        
                    $this->reply = "<h1>¡Éxito en el registro!</h1><hr/>
                    <p>{$_POST['name']}, te has registrado correctamente.</p>
                    <p>Puedes iniciar sesión en el siguiente enlace.</p>
                    <br>
                    <a href='./index.php'><button>Iniciar sesión</button></a>\n";
                }
                else {
                    $this->reply = "<h1>¡Ha ocurrido un error!</h1><hr/>".
                    "<p>¡Ya existe un usuario con este nombre!</p>
                    <p>Vuelve a intetarlo o prueba a inicia sesión.</p>
                    <a href='./'><button>Iniciar Sesión</button></a>
                    <form method='post' action='./'><button name='register' id='register'>Registro</button></form>\n";
                }
                $resultado->free();
            }
            else {
                $this->reply = "<h1>¡Ha ocurrido un error!</h1><hr/>".
                "<p>Los datos introducidos no son válidos.</p>
                <p>Vuelve a intetarlo o prueba a inicia sesión.</p>
                <a href='./'><button>Iniciar Sesión</button></a>
                <form method='post' action='./'><button name='register' id='register'>Registro</button></form>\n";
            }
        }

        // Metodo auxiliar que comprueba la validez de los parametros
        private function test_input($input){
            return htmlspecialchars(trim(strip_tags($input)));
        }

        public function getReply() {
            return $this->reply;
        }
    }
?>