<?php
    include_once('./includes/film_dto.php');	
    include_once('./includes/film_dao.php');		

    $bd = new FilmDAO("complucine");
    //siempre accedemos a traves de los nombres de los formularios o div
    if(isset($_REQUEST['delete_film'])) {    
            $bd->deleteFilm($_REQUEST['id']); 
    }
    header("Location: ../panel_admin/index.php?state=mf");

?>