<?php
    session_start();
    include_once('./includes/film_dto.php');	
    include_once('./includes/formFilm.php');
    if($_REQUEST['confirm_delete_film']) {
        $film = new FormFilm();
        $film->processesForm($_REQUEST['id'],null,null,null,null,"del");
        $_SESSION['message'] = $film->getReply();
        
    }
    header("Location: ../panel_admin/index.php?state=mf");
?>