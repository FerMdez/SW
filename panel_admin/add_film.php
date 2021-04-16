<?php
    session_start();
    include_once('./includes/film_dto.php');	
    include_once('./includes/formFilm.php');	
    
    if($_REQUEST['add_film']) {
        $film = new FormFilm();
        $film->processesForm(null, $_REQUEST['tittle'], $_REQUEST['duration'], $_REQUEST['language'], $_REQUEST['description'], "new");
        $_SESSION['message'] = $film->getReply();
        header("Location: ../panel_admin/index.php?state=mf");
    }

?>