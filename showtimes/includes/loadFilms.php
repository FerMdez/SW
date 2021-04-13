<?php
    require_once($prefix.'panel_admin/includes/film_dao.php');

    // ESTA CLASE SE HA CREADO PARA PODER INSTANCIAR ATRIBUTOS DE LA TABLA PELÍCULAS, 
    // SEGÚN VAYAN SIENDO RELEVANTES PARA MOSTRAR EN FUNCIÓN DE LA PÁGINA QUE LLAME A ESTA CLASE.
    // NO TODAS LAS PÁGINAS DEL CINE NECESITAN CARGAR TODOS LOS ATRIBUTOS POR COMPLETO DE LA TABLA PELÍCULAS
    // Y HEMOS CREIDO, QUE EN ESE CASO, MÁS EFICIENTE HACERLO A PETICIÓN.
    class loadFilms {

        //Atributes:
        private $films;         //Array of movie titles.
        private $descriptions;  //Array of movie descriptions.

        //Constructor:
        public function __construct() {
            $this->load();
        }

        //Methods:
        //Returns an array with the titles of the available movies.
        public function getFilms(){
            return $this->films;
        }

        //Returns an array with the descriptions of the available movies.
        public function getDescription(){
            $this->loadDescriptions();
            return $this->descriptions;
        }

        //Load the list of tittles of the movies.
        private function load(){
            $this->films = array();
            $tittles = new Film_DAO("complucine");
            $reply = $tittles->tittleFilmData();

            if($reply && $reply->num_rows>0){
                $i = 0;
                while ($row = $reply->fetch_assoc()){
                    foreach($row as $key => $value){
                        $this->films[$i] = $value;
                    } 
                    $i++;
                }
            }

            $reply->free();
        }

        private function loadDescriptions(){
            $this->descriptions = array();
            $desc = new Film_DAO("complucine");
            $reply = $desc->descriptionFilmData();

            if($reply && $reply->num_rows>0){
                $i = 0;
                while ($row = $reply->fetch_assoc()){
                    foreach($row as $key => $value){
                        $this->descriptions[$i] = $value;
                    } 
                    $i++;
                }
            }

            $reply->free();
        }
    }
?>