<?php
    //General Config File:
    require_once('../assets/php/config.php');

    //Form Ticket to purchase:
    require_once('includes/formSelectCinemaSession.php');
    $form = new FormSelectCinemaSession();
    $formHTML = $form->gestiona();

    //Page-specific content:
    $section = '<!-- Purchase -->
        <section id="purchase">
            <div class="row">
                '.$formHTML.'
            </div>
        </section>
        ';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';

    //TO-DO: añadir elegir promociones y enviar con el POST.
?>
