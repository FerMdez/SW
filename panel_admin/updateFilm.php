<?php
    include_once('./includes/film_dto.php');	
    include_once('./includes/formFilm.php');	
    
    if(isset($_REQUEST['edit_film'])) {
        echo'<div class="column size">
        <h2>Editar pelicula</h2>
        <form method="post" action="update_film.php">
            <div class="row">
            <fieldset id="film_form">
                <legend>Datos de pelicula</legend>
                <input type="hidden" name="id" value='.$_REQUEST['id'].'/>
                <div>
                    <input type="text" name="tittle" value='.$_REQUEST['tittle'].' />
                </div>
                <div>
                    <input type="number" name="duration" id="duration" value='.$_REQUEST['duration'].' />
                </div>
                <div>
                    <input type="text" name="language" id="language" value='.$_REQUEST['language'].' />
                </div>
                <div>
                <input type="text" name="description" id="description" value="'.$_REQUEST['description'].'"/>
            </div>
                </fieldset>
                <div class="actions"> 
                    <input type="submit" id="submit" value="Editar" name="confirm_edit_film" class="primary" />
                    <input type="reset" id="reset" value="Borrar" />       
                    </div>
                </div>
                </form>
                </div>';

    }
    else if(isset($_REQUEST['delete_film'])) {
        echo'<div class="column size">
        <h2>Editar pelicula</h2>
        <form method="post" action="update_film.php">
            <div class="row">
            <fieldset id="film_form">
                <legend>¿Estás seguro de que quieres eliminar esta pelicula?</legend>
                <input type="hidden" name="id" value='.$_REQUEST['id'].'/>
                <p>Id: '.$_REQUEST['id'].' </p>
                <p>Título: '.$_REQUEST['tittle'].' </p>
                <p>Duración: '.$_REQUEST['duration'].' </p>
                <p>Idioma: '.$_REQUEST['language'].' </p>
                <p>Descripción: '.$_REQUEST['description'].' </p>
                </fieldset>
                <div class="actions"> 
                    <input type="submit" id="submit" value="Eliminar" name="confirm_delete_film" class="primary" />
                    <input type="submit" id="submit" value="Cancelar" name="cancel_delete_film" class="primary" />
                    </div>
                </div>
                </form>
                </div>';

    }
   

?>