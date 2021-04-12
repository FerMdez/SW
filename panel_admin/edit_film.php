<?php
    include_once('./includes/film_dto.php');	
    include_once('./includes/film_dao.php');
    
    
    $bd = new FilmDAO("complucine");
    
    if( $_REQUEST['option'] == 'edit') {
        $film = ($bd->FilmData($_GET["id"]));
        $filmDto=$bd->loadFilm($film['id'],$film['title'],$film['duration'],$film['languaje'].$film['description']);

        echo'<div class="column size">
        <h2>Editar pelicula</h2>
        <form method="post" action="../panel_admin/validate.php">
            <div class="row">
            <fieldset id="film_form">
                <legend>Datos de pelicula</legend>
                <div>
                    <input type="text" name="title" id="title" value=\"".$filmDto.getTittle()."\" placeholder="Título" /> 
                </div>
                <div>
                    <input type="number" name="duration" id="duration" value=\"".$filmDto.getDuration()."\" placeholder="Duración" />
                </div>
                <div>
                    <input type="text" name="lenguage" id="language" value=\"".$filmDto.getLanguage()."\" placeholder="Idioma" />
                </div>
                <div>
                <input type="text" name="description" id="description" value=\"".$filmDto.getDescription()."\" placeholder="Descripción" />
            </div>
                </fieldset>
                <div class="actions"> 
                    <input type="submit" id="submit" value="Editar pelicula" name="edit_film" class="primary" />
                    <input type="reset" id="reset" value="Borrar" />       
                    </div>
                </div>
                </form>
                </div>'."\n";
        }
    }
?>