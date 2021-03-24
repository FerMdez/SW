<?php
    // TO-DO: Completar
    class DAO {
        public $mysqli;
    
        public function __construct(){
            try{
                if (!$this->mysqli) {
                    $this->mysqli = new mysqli('127.0.0.1', 'sw', 
                                            '_admin_', 'complucine');
                }
                // echo "Conexión a la BD, satisfactoria.";
            } catch (Exception $e){
                echo "Error de conexión a la BD: ". mysqli_connect_error();
                exit();
            }

            /* ... */
        }

        public function __destruct(){
            $this->mysqli->close();
        }
    }
?>