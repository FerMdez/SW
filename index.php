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
        </section>
        <section id="promociones" class="row">
            <div class="code">
                <section class="promotions">
                    <button id="retroceder">Anterior</button>
                    <a href="promotions/" class="imagen"></a>
                    <button id="avanzar">Siguiente</button>
                </section>
                <section class="controls">
                    <button id="play">&#x25b6;</button>
                    <button id="stop" disabled>||</button>
                </section>
            </div>
        </section>
        ';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>
