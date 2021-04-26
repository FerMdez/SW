<?php
    class Panel {
        public $state;
        public $login;
        function __construct($panel, $login){
            $this->state = $panel;
            $this->login= $login;
        }

        function showPanel() {
            if($this->login){
                switch($this->state) {
                    case 'uf': require_once('updateFilm.php');break;
                    case 'mc': /*require_once('manage_cinemas.php')*/;echo"<h1>En construcción</h1>"; break;
                    case 'mf': require_once('manage_films.php'); break;
                    case 'md': /*require_once('manage_discounts.php')*/;echo"<h1>En construcción</h1>"; break;
                    case 'mm': /*require_once('manage_managers.php')*/;echo"<h1>En construcción</h1>"; break;
                    case 'un': echo"<h1>En construcción</h1>"; break;
                    case 'ur': echo"<h1>En construcción</h1>";; break;
                    case 'ag': echo"<h1>En construcción</h1>";; break;
                    default: echo "<h1>BIENVENIDO AL PANEL DE ADMINISTRADOR</h1>"; break;
                }
            }
            else {
                echo "<h1>NO TIENES PERMISOS DE ADMINISTRADOR</h1>";
            }
        }
    }
?>

