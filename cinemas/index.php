<?php 
    //General Config File:
    require_once('../assets/php/config.php');

    //Page-specific content:
    $section = '<!-- Cinemas -->
        <section id="cinemas">
            <div class="row">
            '.$template->print_cinemas().'
            </div>
        </section>
        ';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>