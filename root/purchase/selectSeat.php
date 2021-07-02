<?php
    //General Config File:
    require_once('../assets/php/config.php');

    //Seats form:
    require_once('includes/formSelectSeat.php');
    $form = new FormSelectSeat();
    $formHTML = $form->gestiona();

    //Page-specific content:
    $section = '<section class="row">
                    <!-- Seat Form -->
                    '.$formHTML.'
                </div>';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>