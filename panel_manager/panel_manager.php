<?php
    class Panel {
        public $state;
        public $login;
        
        function __construct($panel,$log){
            $this->state = $panel;
            $this->login = $log;

        }

        function showPanel() {
            if($this->login){
                switch($this->state) {
                    case 'us_u': echo "<p> Esta vista no esta implementada </p>"; break;
                    case 'us_r': echo "<p> Esta vista no esta implementada </p>"; break;
                    case 'rooms': require_once('manage_rooms.php');  break;
                    case 'sessions': require_once('manage_sessions.php'); break;
                    case 'edit_session': require_once('edit_sessions.php'); break;
                    default: require('hello_panel.php'); break;
                }
            }
            else{
                echo "<h1> Error no tienes los permisos necesarios de gerente</h1>";
            }
        }
    }
?>