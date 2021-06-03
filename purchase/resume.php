<?php
    //General Config File:
    require_once('../assets/php/config.php');

    //Get purchase summary
    include_once($prefix.'assets/php/includes/purchase.php');
    include_once($prefix.'assets/php/includes/film.php');
    include_once($prefix.'assets/php/includes/session_dao.php');
    include_once($prefix.'assets/php/includes/session.php');
    include_once($prefix.'assets/php/includes/cinema_dao.php');
    include_once($prefix.'assets/php/includes/cinema.php');

    if(isset($_SESSION["purchase"]) && isset($_SESSION["film_purchase"])){
        $purchase = unserialize($_SESSION["purchase"]);
        $film_purchase = unserialize($_SESSION["film_purchase"]);
        $sessionDAO = new SessionDAO("complucine");
        $session = $sessionDAO->sessionData($purchase->getSessionId());
        $cinemaDAO = new Cinema_DAO("complucine");
        $cinema = $cinemaDAO->cinemaData($purchase->getCinemaId());

        $seatsArray = array_combine(unserialize($purchase->getRow()), unserialize($purchase->getColumn()));
        $seats = "";
        for($i=0; $i < count(unserialize($purchase->getRow())); $i++){
            $seats .= unserialize($purchase->getRow())[$i]."-".unserialize($purchase->getColumn())[$i].", ";
        }

        unset($_SESSION["purchase"]);
        unset($_SESSION["film_purchase"]);

        $reply = "<h2>Se ha realizado su compra con éxito, a continuación puede ver el resumen:</h2><hr />
                    <div class='column left'>
                        <img src='".$prefix."img/films/".$film_purchase->getImg()."' alt='".$film_purchase->getTittle()."' />
                        <p>Película: ".str_replace('_', ' ', strtoupper($film_purchase->getTittle()))."</p>
                        <p>Duración: ".$film_purchase->getDuration()." minutos</p>
                        <p>Idioma: ".$film_purchase->getLanguage()."</p>
                        <p>Precio: ".$session->getSeatPrice()*count(unserialize($purchase->getRow()))." €</p>
                    </div>
                    <div class='column right'>
                        <p>Sesión (Fecha): ".$session->getDate()."</p>
                        <p>Sesión (Hora): ".$session->getStartTime()."</p>
                        <p>Cine: ".$cinema->getName()."</p>
                        <p>Sala: ".$purchase->getHallId()."</p>
                        <p>Asiento(s): ".$seats."</p>
                        <p>Fecha de la Compra: ".$purchase->getTime()."</p>
                    </div>
                    ";

        if(isset($_SESSION["login"]) && $_SESSION["login"] == true){
            $actions = '<h3>Guarde esta información y enséñela para entrar al cine.</h3><hr />
                        <p>Se ha guardado la información de la compra en su panel de usuario.</p>
                        <button onclick="javascript:window.print()">Imprimir<//button>
                        <a href="'.$prefix.'panel_user/?option=purchases"><button>Mi Historial</button></a>
                        ';
        } else {
            $actions = '<h3>Guarde esta información y enséñela para entrar al cine.</h3><hr />
                        <button onclick="javascript:window.print()">Imprimir<//button>
                        <!-- <button onclick="javascript:window.print()">Guardar<//button> -->
                        ';
        }
    } else {
        $reply = '<h2>No se han encontrado datos de compra<h2>';
        $actions = '';
    }

    //Page-specific content:
    $section = '<!-- Purchase Summary -->
                    <section id="purchase_summary">
                    <div class="row">
                        <section class="code">
                        '.$reply.'
                        </section>
                        <section class="code resume">
                        '.$actions.'
                        </section>
                    </div>
                </section>
                ';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>