<?php
    //General Config File:
    require_once('../assets/php/config.php');

    $sessionDAO = new SessionDAO("complucine");
    //$session = $sessionDAO->loadSession($_POST["session_id"], $_POST["film_id"], $_POST["hall_id"], $_POST["cinema_id"], $_POST["date_"], $_POST["hour_"], "12", null, null);
    $session = $sessionDAO->sessionData($_POST["session_id"]);
    

    //Purchase form:
    require_once('includes/formPurchase.php');
    $form = new FormPurchase();
    $formHTML = $form->gestiona();

    //Page-specific content:
    $section = '<div class="code">
                    <h2>Completar la Compra</h2><hr />
                    <!-- Purchase Form -->
                    '.$formHTML.'
                </div>';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>