<?php
    require_once($prefix.'assets/php/includes/user.php');

    class UserPanel {
        //Atributes:
        
        //Constructor:
        function __construct(){}

        //Methods:

        //Welcome view.
        static function panel(){
            $name = strtoupper(unserialize($_SESSION['user'])->getName());
            $email = unserialize($_SESSION['user'])->getEmail();
            $userPic = USER_PICS.strtolower($name).".jpg";

            $forms = self::manage();

            return $reply = '<div class="code info">
                    <h1>Bienvenido '.$name.' a tu Panel de Usuario.</h1>
                    <hr />
                    <a href="./?option=change_profile_pic"><img src='.$userPic.' alt="user_profile_picture"/></a>
                    <h3>'.strftime("%A %e de %B de %Y | %H:%M").'</h3>
                    <br />
                    <p>Usuario: '.$name.'</p>
                    <p>Email: '.$email.'</p>
                </div>'."\n".$forms;
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

            return $reply = '
                <!-- Cambiar Información de la Usuario -->
                <br /><h2>Cambiar información de la cuenta</h2><hr />
                <!-- Change User Name -->
                <div class="column side">
                    <h2>Cambiar nombre de usuario</h2>
                    '.$htmlFormChangeName.'
                </div>
                <!-- Change User Password -->
                <div class="column middle">
                    <h2>Cambiar contraseña</h2>
                    '.$htmlFormChangePass.'
                </div>
                <!-- Change User Email -->
                <div class="column side">
                    <h2>Cambiar email de usuario</h2>
                    '.$htmlFormChangeEmail.'
                </div>'."\n";
        }

        //User purchase history.
        static function changeUserPic(){

            require_once('./includes/formUploadPic.php');

            $formCP = new FormUploadFiles();
            $htmlFormChangeUserPic = $formCP->gestiona();

            $name = strtoupper(unserialize($_SESSION['user'])->getName());
            $userPic = USER_PICS.strtolower($name).".jpg";

            return $reply = '<!-- Form Change User Profile Picture -->
                            <div class="column side"></div>
                            <div class="column middle">
                                <div class="code info">
                                    <h1>Cambiar imagen de perfil</h1><hr />
                                    <img src='.$userPic.' alt="user_profile_picture"/>
                                    '.$htmlFormChangeUserPic.'
                                </div>
                            </div>
                            <div class="column side"></div>'."\n";
        }

        //User purchase history.
        static function purchases(){
            require_once('../assets/php/includes/purchase_dao.php');

            $purchasesHTML = '';

            $purchaseDAO = new PurchaseDAO("complucine");
            $purchases = $purchaseDAO->allPurchasesData(unserialize($_SESSION['user'])->getId());

            if($purchases){
                $sessions = array();
                $halls = array();
                $cinemas = array();
                $rows = array();
                $columns = array();
                $dates = array();
                foreach($purchases as $key=>$value){
                    $sessions[$key] = $value->getSessionId();
                    $halls[$key] = $value->getHallId();
                    $cinemas[$key] = $value->getCinemaId();
                    $rows[$key] = $value->getRow();
                    $columns[$key] = $value->getColumn();
                    $dates[$key] = $value->getTime();
                }
                for($i = 0; $i < count($purchases); $i++){
                    if($i%2 === 0){
                        if($i != 0) $purchasesHTML .= '</div>
                        ';
                        $purchasesHTML .= '<div class="column left">
                        ';
                    } else {
                        if($i != 0) $purchasesHTML .= '</div>
                        ';
                        $purchasesHTML .= '<div class="column left">
                        ';
                    }
                    $purchasesHTML .= '<h1>Compara realizada el: '.$dates[$i].'</h1><hr />
                                        <p>Cine: '.$cinemas[$i].'</p>
                                        <p>Sala: '.$halls[$i].'</p>
                                        <p>Sesión: '.$sessions[$i].'</p>
                                        <p>Asiento(Fila): '.$rows[$i].'</p>
                                        <p>Asiento(Columna): '.$columns[$i].'</p>';
                }
            }
            
            return $reply = '<div class="code info">
                            <h2>Historial de compras</h2><hr />
                            '.$purchasesHTML.'
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
            require_once('./includes/formDeleteAccount.php');

            $formDA = new FormDeleteAccount();
            $htmlFormDeleteAccount = $formDA->gestiona();

            return $reply = '<div class="code">
                        <h2>ELIMINAR CUENTA DE USUARIO</h2><hr />
                        <div class="column side"></div>
                        <!-- Delete User Form -->
                        <div class="column middle">
                            '.$htmlFormDeleteAccount.'
                        </div>
                        <div class="column side"></div>
                        </div>'."\n";
        }
    }
?>