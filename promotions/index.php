<?php 
    //General Config File:
    require_once('../assets/php/config.php');
    
    //Specific page content:
    $section = '<!-- Promotions -->
        <section class="row">
            <section id="promociones">
                '.$template->print_promotions().'
            </section>
        </section>
        ';
    
    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>