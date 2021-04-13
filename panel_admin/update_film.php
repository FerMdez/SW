<?php
    session_start();
    include_once('./includes/film_dto.php');	
    include_once('./includes/formFilm.php');	
    
    if(isset($_REQUEST['add_film'])) {
        $film = new FormFilm();
        $film->processesForm(null, $_REQUEST['tittle'], $_REQUEST['duration'], $_REQUEST['language'], $_REQUEST['description'], "new");
        $_SESSION['message'] = $film->getReply();
    }
    else if(isset($_REQUEST['confirm_delete_film'])) {
        $film = new FormFilm();
        $film->processesForm($_REQUEST['id'],null,null,null,null,"del");
        $_SESSION['message'] = $film->getReply();
    }
    else if(isset($_REQUEST['confirm_edit_film'])) {
        $film = new FormFilm();
        $film->processesForm($_REQUEST['id'], $_REQUEST['tittle'], $_REQUEST['duration'], $_REQUEST['language'], $_REQUEST['description'], "edit");
        $_SESSION['message'] = $film->getReply();
    }
    header("Location: ../panel_admin/index.php?state=mf");

?>