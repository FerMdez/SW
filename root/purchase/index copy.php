<?php
    //General Config File:
    require_once('../assets/php/config.php');

    //Get Film to purchase:
    include_once($prefix.'assets/php/includes/film_dao.php');
    include_once($prefix.'assets/php/includes/film.php');
    include_once($prefix.'assets/php/includes/cinema_dao.php');
    include_once($prefix.'assets/php/includes/cinema.php');
    include_once($prefix.'assets/php/includes/session_dao.php');
    include_once($prefix.'assets/php/includes/session.php');

    $TODAY = getdate();
    $TODAY = "$TODAY[mday]"."-"."$TODAY[mon]"."-"."$TODAY[year]";

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
            
                $cinemasListHTML = '<form action="confirm.php" method="post">
                                    <select name="cinemas" id="cinemas">';
                foreach($cinemasIT as $value){
                    if($value == reset($cinemasIT)){
                        $cinemasListHTML .= '<option value="'.$value["cID"].'" selected>'.$value["NAME"].'</option>';
                    } else {
                        $cinemasListHTML .='<option value="'.$value["cID"].'">'.$value["NAME"].'</option>';
                    }
                }
                $cinemasListHTML .= '</select>';
            } else {
                $cinemasListHTML = '<select name="cinemas"><option value="" selected>No hay cines disponibles para esta película.</option></select></form>';
            }

            $fiml_id = $film->getId();
            $cinema_id = $value["cID"];

            $sessionsDAO = new SessionDAO("complucine");
            $sessions = $sessionsDAO->getSessions_Film_Cinema($fiml_id, $cinema_id);
            if(!empty($sessions)){
                $sessionsDates = new ArrayIterator(array());
                $sessionsStarts = new ArrayIterator(array());
                $sessionsHalls = new ArrayIterator(array());
                $sessionsIDs = new ArrayIterator(array());
                foreach($sessions as $key=>$value){
                    $sessionsIDs[$key] = $value->getId();
                    $sessionsDates[$key] = date_format(date_create($value->getDate()), 'j-n-Y');
                    $sessionsHalls[$key] = $value->getIdhall();
                    $sessionsStarts[$key] = $value->getStartTime();
                }
                $sessionsIT = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
                $sessionsIT->attachIterator($sessionsIDs, "sID");
                $sessionsIT->attachIterator($sessionsDates, "DATE");
                $sessionsIT->attachIterator($sessionsHalls, "HALL");
                $sessionsIT->attachIterator($sessionsStarts, "HOUR");

                $count = 0;
                $sessionsListHTML = '<select name="sessions" id="sessions">';
                foreach ($sessionsIT as $value) {
                    if($TODAY <= $value["DATE"]){
                        if($value === reset($sessionsIT)){
                            $sessionsListHTML .= '<option value="'.$value["sID"].'" >Fecha: '.$value["DATE"].' | Hora: '.$value["HOUR"].' | Sala: '.$value["HALL"].'</option>';
                        } else {
                            $sessionsListHTML .='<option value="'.$value["sID"].'">Fecha: '.$value["DATE"].' | Hora:'.$value["HOUR"].' | Sala: '.$value["HALL"].'</option>';
                        }
                        $count++;
                    }
                }
                $sessionsListHTML .= '</select>';

                if($count == 0) {
                    $sessionsListHTML = '<select name="sessions"><option value="" selected>No hay sesiones disponibles para esta película.</option></select>'; 
                    $pay = false;
                }
            } else {
                $sessionsListHTML = '<select name="sessions"><option value="" selected>No hay sesiones disponibles para esta película.</option></select>';
                $pay = false;
            }

            //$session_id = $value["sID"];
            //$hall_id = $value["HALL"];
            //$date_ = $value["DATE"];
            //$hour_ = $value["HOUR"];

            //Reply: Depends on whether the purchase is to be made from a selected movie or a cinema.
            $reply = '<div class="column left">
                        <h2>Película seleccionada: '.str_replace('_', ' ', $tittle).'</h2><hr />
                        <div class="image"><img src="'.$prefix.'img/films/'.$tittle.'.jpg" alt="'.$tittle.'" /></div>
                        <p>Duración: '.$film->getDuration().' minutos</p>
                        <p>Idioma: '.$film->getLanguage().'</p>
                    </div>
                    <div class="column right">
                        <h2>Seleccione un Cine y una Sesión</h2><hr />
                            <h3>Cines</h3>        
                            '.$cinemasListHTML.'
                            <h3>Sesiones</h3>
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
        $pay = '<input type="submit" id="submit" value="Pagar" />
                </form>';
    } else {
        $pay = '</form>';
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
