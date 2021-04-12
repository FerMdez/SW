<?php
    include_once('./includes/film_dto.php');	
    include_once('./includes/film_dao.php');		

    $bd = new FilmDAO("complucine");
    //siempre accedemos a traves de los nombres de los formularios o div
    if(isset($_REQUEST['add_film'])) {
       if(isset($_REQUEST['tittle'])) {
            $film = new FilmDTO(null, $_REQUEST['tittle'], $_REQUEST['duration'], $_REQUEST['language'], $_REQUEST['description']);
            $bd->addFilm($film);
        }
        
    }
    header("Location: ../panel_admin/index.php?state=mf");

?>