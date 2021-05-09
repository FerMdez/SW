<?php
    require_once($prefix.'assets/php/common/user.php');

    class UserPanel {
        //Atributes:
        
        //Constructor:
        function __construct(){}

        //Methods:

        //Welcome view.
        static function panel(){
            $name = strtoupper($_SESSION['nombre']);
            $email = unserialize($_SESSION['user'])->getEmail();
            return $reply = '<div class="code info">
                    <h1>Bienvenido '.$name.' a tu Panel de Usuario.</h1>
                    <hr />
                    <h3>'.strftime("%A %e de %B de %Y | %H:%M").'</h3>
                    <br />
                    <p>Usuario: '.$name.'</p>
                    <p>Email: '.$email.'</p>
                </div>'."\n";
        }

        //Manage the user account.
        static function manage(){
            require_once('./includes/formChangePass.php');
            require_once('./includes/formChangeEmail.php');
            require_once('./includes/formChangeName.php');

            $formCN = new FormChangeName();
            $htmlFormChangeName = $formCN->gestiona();
            
            $formCP = new FormChangePass();
            $htmlFormChangePass = $formCP->gestiona();

            $formCE = new FormChangeEmail();
            $htmlFormChangeEmail = $formCE->gestiona();

            return $reply = '<!-- Change User Name -->
                <div class="column side">
                    <h2>Cambiar nombre de usuario</h2>
                    '.$htmlFormChangeName.'
                </div>
                <div class="column middle">
                    <h2>Cambiar contraseña</h2>
                    '.$htmlFormChangePass.'
                </div>
                <div class="column side">
                    <h2>Cambiar email de usuario</h2>
                    '.$htmlFormChangeEmail.'
                </div>'."\n";
        }

        //User purchase history.
        static function purchases(){
            return $reply = '<div class="code info">
                            <h2>Aquí el historial de compras</h2><hr />
                        </div>'."\n";
        }

        //User payment details
        static function payment(){
            return $reply = '<div class="code info">
                            <h2>Aquí los datos de pago</h2><hr />
                        </div>'."\n";
        }

        //Delete user account.
        static function delete(){
            return $reply = '<div class="code info">
                        <h2>Aquí el formulario para eliminar cuenta</h2><hr />
                        </div>'."\n";
        }
    }
?>