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
        $cinemasNames = array();
        foreach($cinemas as $key=>$value){
            $cinemasNames[$key] = $value->getName();
        }
        foreach($cinemasNames as $value){
            $cinemasListHTML = '<select name="cinemas">
                                <option value="'.$value.'">'.$value.'</option>
                            </select>';
         }
    }
    

    //Reply: Depends on whether the purchase is to be made from a selected movie or a cinema.
    $reply = '<div class="column left">
                        <h2>Película seleccionada: '.str_replace('_', ' ', $tittle).'</h2><hr />
                        <div class="image"><img src="'.$prefix.'img/films/'.$tittle.'.jpg" alt="'.$tittle.'" /></div>
                        <p>Duración: '.$film->getDuration().'</p>
                        <p>Idioma: '.$film->getLanguage().'</p>
                    </div>
                    <div class="column right">
                        <h2>Seleccione un Cine y una Sesión</h2><hr />           
                            '.$cinemasListHTML.'
                    </div>
                        ';
    
    //Page-specific content:
    $section = '<!-- Purchase -->
        <section id="purchase">
            <div class="row">
                <section class="code">
                   '.$reply.'
                </section>
            </div>
        </section>
        ';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>
