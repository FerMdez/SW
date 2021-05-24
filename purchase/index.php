<?php
    //General Config File:
    require_once('../assets/php/config.php');

    //Get Film to purchase:
    include_once($prefix.'assets/php/includes/film_dao.php');
    include_once($prefix.'assets/php/includes/film.php');
    include_once($prefix.'assets/php/includes/cinema_dao.php');
    include_once($prefix.'assets/php/includes/cinema.php');
    include_once($prefix.'assets/php/includes/session.php');

    $film = null;
    $cinemas = [];
    if(isset($_GET["film"])){
        $filmDAO = new Film_DAO("complucine");
        $film = $filmDAO->FilmData($_GET["film"]);
        $tittle = $film->getTittle();

        $cinemas = $filmDAO->getCinemas($_GET["film"]);
        if(!empty($cinemas)){
            $cinemasNames = new ArrayIterator(array());
            $cinemasIDs = new ArrayIterator(array());
            foreach($cinemas as $key=>$value){
                $cinemasIDs[$key] = $value->getId();
                $cinemasNames[$key] = $value->getName();
            }
            $cinemasIT = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
            $cinemasIT->attachIterator($cinemasIDs, "ID");
            $cinemasIT->attachIterator($cinemasNames, "NAME");
        
            $cinemasListHTML = '<select name="cinemas">';
            foreach($cinemasIT as $value){
                if($value == reset($cinemasIT)){
                    $cinemasListHTML .= '<option value="'.$value["ID"].'" selected>'.$value["NAME"].'</option>';
                } else {
                    $cinemasListHTML .='<option value="'.$value["ID"].'">'.$value["NAME"].'</option>';
                }
            }
            $cinemasListHTML .= '</select>';
        } else {
            $cinemasListHTML = '<select name="cinemas"><option value="" selected>No hay cines disponibles para esta película.</option></select>';
        }

        $cinemaDAO = new Cinema_DAO("complucine");
        $sessions = $cinemaDAO->getSessions($value["ID"]);
        if(!empty($sessions)){
            $sessionsDates = new ArrayIterator(array());
            $sessionsStarts = new ArrayIterator(array());
            $sessionsIDs = new ArrayIterator(array());
            foreach($sessions as $key=>$value){
                $sessionsIDs[$key] = $value->getId();
                $sessionsDates[$key] = $value->getDate();
                $sessionsStarts[$key] = $value->getStartTime();
            }
            $sessionsIT = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
            $sessionsIT->attachIterator($sessionsIDs, "ID");
            $sessionsIT->attachIterator($sessionsDates, "DATE");
            $sessionsIT->attachIterator($sessionsStarts, "HOUR");

            $sessionsListHTML = '<select name="sessions">';
            foreach ($sessionsIT as $value) {
                if($value == reset($sessionsIT)){
                    $sessionsListHTML .= '<option value="'.$value["ID"].'" selected>'.$value["DATE"].' | '.$value["HOUR"].'</option>';
                } else {
                    $sessionsListHTML .='<option value="'.$value["ID"].'">'.$value["DATE"].' | '.$value["HOUR"].'</option>';
                }
            }
            $sessionsListHTML .= '</select>';
        } else {
            $sessionsListHTML = '<select name="sessions"><option value="" selected>No hay sesiones disponibles para esta película.</option></select>';
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
                            '.$sessionsListHTML.'
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
