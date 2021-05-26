<?php
    class DAO {

        //Atributes:
        public $mysqli;

        //Constructor:
        public function __construct($bd_name){
            if($bd_name != BD_NAME) {
                echo "Está intentando acceder a una base de datos que no existe, puede que la aplicación no funcione correctamente.";
            }
            $app = Aplicacion::getSingleton();
            $this->mysqli = $app->conexionBd();
        }

        //Destructor (Ya no es necesdario):
        /*
        public function __destruct(){
            $this->mysqli->close();
        }
        */

    }
?>