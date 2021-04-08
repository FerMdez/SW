<?php
    class Panel {
        public $state;
        
        function __construct($panel){
            $this->state = $panel;
        }

        function showPanel() {
            switch($this->state) {
				case 'us_u': require('user_unregistered_view.php'); break;
                case 'us_r': require('user_registered_view.php'); break;
                case 'rooms': require('manage_rooms.php');  break;
                case 'sessions': require('manage_sessions.php'); break;
				case 'edit_session': require('edit_sessions.php'); break;
                default: echo "<h1>BIENVENIDO AL PANEL DE GERENTE </h1>
						<br>
						<p> Espero que este pasando un buen dia </p>
				</div>"; break;
            }
        }
    }
?>