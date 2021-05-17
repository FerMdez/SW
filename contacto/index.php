<?php 
    //General Config File:
    require_once('../assets/php/config.php');

    //Contact form:
    require_once('includes/formContact.php');
    $form = new FormContact();
    $htmlForm = $form->gestiona();
    
    //Specific page content:
    $section = '<!-- Contact Form -->
        <section id="formulario">
            <h4>Formulario (EN DESARROLLO)</h4>
            '.$htmlForm.'
        </section>
        ';
    
    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>
