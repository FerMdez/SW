<?php
    class Panel {
        public $state;
        
        function __construct($panel){
            $this->state = $panel;
        }

        function showPanel() {
            switch($this->state) {
                case 'ef': require('editFilm.php');break;
                case 'mc': require('manage_cinemas.php'); break;
                case 'mf': require('manage_films.php'); break;
                case 'md': require('manage_discounts.php'); break;
                case 'mm': require('manage_managers.php'); break;
                default: echo "<h1>BIENVENIDO AL PANEL DE ADMINISTRADOR</h1>"; break;
            }
        }
    }
?>

