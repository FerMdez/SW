<?php
    //General Config File:
    require_once(__DIR__.'/assets/php/config.php');

    //Page-specific content:
    $section = '<!-- Undercard -->
                <section id="cartelera">
                    <div class="row">
                        <div class="code">
                            '.$template->print_fimls().'
                        </div>
                    </div>
                </section>';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>
