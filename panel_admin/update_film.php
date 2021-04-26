<?php
    include_once('./includes/film_dto.php');	
    include_once('./includes/formFilm.php');	
    
    if(isset($_POST['add_film'])) {
        $film = new FormFilm();
        $film->processesForm(null, $_POST['tittle'], $_POST['duration'], $_POST['language'], $_POST['description'], "new");
        $_SESSION['message'] = $film->getReply();
    }
    else if(isset($_POST['confirm_delete_film'])) {
        $film = new FormFilm();
        $film->processesForm($_POST['id'],null,null,null,null,"del");
        $_SESSION['message'] = $film->getReply();
    }
    else if(isset($_POST['confirm_edit_film'])) {
        $film = new FormFilm();
        $film->processesForm($_POST['id'], $_POST['tittle'], $_POST['duration'], $_POST['language'], $_POST['description'], "edit");
        $_SESSION['message']= $film->getReply();
    }
    header('Location: ../panel_admin/index.php?state=mf');

?>