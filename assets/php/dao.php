<?php
    // TO-DO: Completar
    class DAO {
        //Constants:
        private const _SERVERNAME = "localhost";
        private const _USERNAME = "sw";
        private const _PASSWORD = "_admin_";
        private const _BD = "complucine";

        //Atributes:
        public $mysqli;

        //Constructor:
        public function __construct($bd_name){
            if($bd_name == null) $bd_name = self::_BD;
            try{
                if (!$this->mysqli) {
                    $this->mysqli = new mysqli(self::_SERVERNAME, self::_USERNAME, 
                                                self::_PASSWORD, $bd_name);
                }
                // echo "Conexión a la BD, satisfactoria.";
            } catch (Exception $e){
                echo "Error de conexión a la BD: ". mysqli_connect_error();
                exit();
            }

            /* ... */
        }

        //Destructor:
        public function __destruct(){
            $this->mysqli->close();
        }

        //Methods:
    }
?>