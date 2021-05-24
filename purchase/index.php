<?php
    //General Config File:
    require_once('../assets/php/config.php');

    //Get Film to purchase:
    include_once($prefix.'assets/php/includes/film_dao.php');
    include_once($prefix.'assets/php/includes/film.php');
    include_once($prefix.'assets/php/includes/cinema.php');

    $film = null;
    $cinemas = [];
    if(isset($_GET["film"])){
        $filmDAO = new Film_DAO("complucine");
        $film = $filmDAO->FilmData($_GET["film"]);
        $tittle = $film->getTittle();

        $cinemas = $filmDAO->getCinemas($_GET["film"]);
        if(!empty($cinemas)){
            $cinemasNames = array();
            foreach($cinemas as $key=>$value){
                $cinemasNames[$key] = $value->getName();
            }
        
            $cinemasListHTML = '<select name="cinemas">';
            foreach($cinemasNames as $value){
                if($value == reset($cinemasNames)){
                    $cinemasListHTML .= '<option value="'.$value.'" selected>'.$value.'</option>';
                } else {
                    $cinemasListHTML .='<option value="'.$value.'">'.$value.'</option>';
                }
            }
            $cinemasListHTML .= '</select>';
        } else {
            $cinemasListHTML = '<select name="cinemas"><option value="" selected>No hay cines disponibles para esta película.</option></select>';
        }
    }
    

    //Reply: Depends on whether the purchase is to be made from a selected movie or a cinema.
    $reply = '<div class="column left">
                        <h2>Película seleccionada: '.str_replace('_', ' ', $tittle).'</h2><hr />
                        <div class="image"><img src="'.$prefix.'img/films/'.$tittle.'.jpg" alt="'.$tittle.'" /></div>
                        <p>Duración: '.$film->getDuration().' minutos</p>
                        <p>Idioma: '.$film->getLanguage().'</p>
                    </div>
                    <div class="column right">
                        <h2>Seleccione un Cine y una Sesión</h2><hr />
                        <br /><h3>Cines</h3>        
                            '.$cinemasListHTML.'
                        <h3>Sesiones</h3>
                    </div>
                        ';
    
    //Page-specific content:
    $section = '<!-- Purchase -->
        <section id="purchase">
            <div class="row">
                <section class="code purchase">
                   '.$reply.'
                </section>
            </div>
        </section>
        ';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>
