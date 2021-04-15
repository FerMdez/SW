<?php
    require_once('../assets/php/dao.php');
    include_once('./includes/formFilm.php');
        
    if(isset($_POST['edit_film'])) {
        echo'<div class="column size">
        <h2>Editar pelicula</h2>
        <form method="post" action="update_film.php">
            <div class="row">
            <fieldset id="film_form">
                <legend>Datos de pelicula</legend>
                <input type="hidden" name="id" value='.$_POST['id'].'/>
                <div>
                    <input type="text" name="tittle" value="'.$_POST['tittle'].'" />
                </div>
                <div>
                    <input type="number" name="duration" id="duration" value='.$_POST['duration'].' />
                </div>
                <div>
                    <input type="text" name="language" id="language" value="'.$_POST['language'].'" />
                </div>
                <div>
                <input type="text" name="description" id="description" value="'.$_POST['description'].'"/>
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
    else if(isset($_POST['delete_film'])) {
        echo'<div class="column size">
        <h2>Editar pelicula</h2>
        <form method="post" action="update_film.php">
            <div class="row">
            <fieldset id="film_form">
                <legend>¿Estás seguro de que quieres eliminar esta pelicula?</legend>
                <input type="hidden" name="id" value='.$_POST['id'].'/>
                <p>Id: '.$_POST['id'].' </p>
                <p>Título: '.$_POST['tittle'].' </p>
                <p>Duración: '.$_POST['duration'].' </p>
                <p>Idioma: '.$_POST['language'].' </p>
                <p>Descripción: '.$_POST['description'].' </p>
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