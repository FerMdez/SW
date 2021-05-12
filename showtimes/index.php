<?php
    //General Config File:
    require_once('../assets/php/config.php');
    
    //Page-specific content:
    $section = '<!-- Films -->
            <section id="films_billboard">
                <div class="row">
                '.$template->print_fimls().'
                </div>
            </section>';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>
