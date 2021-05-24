<?php 
    //General Config File:
    require_once('../assets/php/config.php');
    
    //Specific page content:
    $section = '<!-- Promotions -->
        <div class="row">
            <section id="promociones">
                '.$template->print_promotions().'
            </section>
        </div>
        ';
    
    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>