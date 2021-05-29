<?php
    //General Config File:
    require_once(__DIR__.'/assets/php/config.php');

    //Promotions:
    include_once(__DIR__.'/assets/php/includes/promotion_dao.php');

    $promotionsDAO = new Promotion_DAO("complucine");
    $promotions = $promotionsDAO->allPromotionData();
    foreach($promotions as $key=>$value){
        $promotions_img[$key] = $value->getImg();
    }

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
                <h2>Promociones</h2>
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
    $section.="<input type='hidden' id='promotions' value='".json_encode($promotions_img)."' />";

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>
