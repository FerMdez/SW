<?php
    //General Config File:
    require_once('../assets/php/config.php');

    //Get Film to purchase:
    include_once($prefix.'assets/php/includes/film_dao.php');
    include_once($prefix.'assets/php/includes/film.php');
    include_once($prefix.'assets/php/includes/cinema_dao.php');
    include_once($prefix.'assets/php/includes/cinema.php');
    include_once($prefix.'assets/php/includes/session.php');

    $pay = true;
    $film = null;
    $cinemas = [];
    $sessions = [];
    if(isset($_GET["film"])){
        $filmDAO = new Film_DAO("complucine");
        $film = $filmDAO->FilmData($_GET["film"]);
        if($film){
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
                $cinemasIT->attachIterator($cinemasIDs, "cID");
                $cinemasIT->attachIterator($cinemasNames, "NAME");
            
                $cinemasListHTML = '<select name="cinemas">';
                foreach($cinemasIT as $value){
                    if($value == reset($cinemasIT)){
                        $cinemasListHTML .= '<option value="'.$value["cID"].'" selected>'.$value["NAME"].'</option>';
                    } else {
                        $cinemasListHTML .='<option value="'.$value["cID"].'">'.$value["NAME"].'</option>';
                    }
                }
                $cinemasListHTML .= '</select>';
            } else {
                $cinemasListHTML = '<select name="cinemas"><option value="" selected>No hay cines disponibles para esta película.</option></select>';
            }

            $fiml_id = $film->getId();
            $cinema_id = $value["cID"];

            $cinemaDAO = new Cinema_DAO("complucine");
            $sessions = $cinemaDAO->getSessions($value["cID"]);
            if(!empty($sessions)){
                $sessionsDates = new ArrayIterator(array());
                $sessionsStarts = new ArrayIterator(array());
                $sessionsHalls = new ArrayIterator(array());
                $sessionsIDs = new ArrayIterator(array());
                foreach($sessions as $key=>$value){
                    $sessionsIDs[$key] = $value->getId();
                    $sessionsDates[$key] = $value->getDate();
                    $sessionsHalls[$key] = $value->getIdhall();
                    $sessionsStarts[$key] = $value->getStartTime();
                }
                $sessionsIT = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
                $sessionsIT->attachIterator($sessionsIDs, "sID");
                $sessionsIT->attachIterator($sessionsDates, "DATE");
                $sessionsIT->attachIterator($sessionsHalls, "HALL");
                $sessionsIT->attachIterator($sessionsStarts, "HOUR");

                $sessionsListHTML = '<select name="sessions">';
                foreach ($sessionsIT as $value) {
                    if($value == reset($sessionsIT)){
                        $sessionsListHTML .= '<option value="'.$value["sID"].'" selected>'.$value["DATE"].' | '.$value["HOUR"].' (Sala: '.$value["HALL"].') '.'</option>';
                    } else {
                        $sessionsListHTML .='<option value="'.$value["sID"].'">'.$value["DATE"].' | '.$value["HOUR"].' (Sala: '.$value["HALL"].') '.'</option>';
                    }
                }
                $sessionsListHTML .= '</select>';
            } else {
                $sessionsListHTML = '<select name="sessions"><option value="" selected>No hay sesiones disponibles para esta película.</option></select>';
            }

            $session_id = $value["sID"];
            $hall_id = $value["HALL"];

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
                            '.$cinemasListHTML.'<br />
                            <br/><h3>Sesiones</h3>
                            '.$sessionsListHTML.'
                    </div>
                        ';
        } else {
            $reply = '<h1>No existe la película.</h1>';
            $pay = false;
        }
    } else if(isset($_GET["cinema"])) {
        $reply = '<h1>ESTAMOS TRABAJANDO EN ELLO</h1>';
        $pay = false;
    } else {
        $reply = '<h1>No se ha encontrado película ni cine.</h1>';
        $pay = false;
    }
    

    //Pay button:
    if($pay){
        $pay = '<form action="confirm.php" method="post">
                        <input type="hidden" name="film_id" id="film_id" value='.$fiml_id.' />
                        <input type="hidden" name="cinema_id" id="cinema_id" value='.$cinema_id.' />
                        <input type="hidden" name="session_id" id="session_id" value='.$session_id.' />
                        <input type="hidden" name="hall_id" id="hall_id" value='.$hall_id.' />
                        <input type="submit" id="submit" value="Pagar" />
                    </form>';
    }
    //Page-specific content:
    $section = '<!-- Purchase -->
        <section id="purchase">
            <div class="row">
                <section class="code purchase">
                   '.$reply.'
                </section>
                <section class="code purchase">
                   '.$pay.'
                </section>
            </div>
        </section>
        ';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>
