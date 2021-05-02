<?php

    //General Config File:
    include_once('../assets/php/config.php');	
    include_once('./includes/formFilm.php');	
    require_once($prefix.'assets/php/common/film_dao.php');
 
   
    // View functions
	/*function drawFilms(){	
        $film = new Film_DAO("complucine");
        $films = $film->allFilmData();
        echo "<div class='column left'>
        <table class='alt'>
            <thead>
            <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Duracion</th>
                <th>Idioma</th>
                <th>Descripcion</th>
            </tr>
            </thead>
            <tbody>"; 
        foreach($films as $f){ 
        echo '
            <tr>
                <td>'. $f->getId() .'</td>
                <td>'. $f->getTittle() .'</td>
                <td>'. $f->getDuration() .'</td>
                <td>'. $f->getLanguage() .'</td>
                <td>'. $f->getDescription().'</td>
                <td>
                    <form method="post" action="index.php?state=mf">
                        <input  name="id" type="hidden" value="'.$f->getId().'">
                        <input  name="tittle" type="hidden" value="'.$f->getTittle().'">
                        <input  name="duration" type="hidden" value="'.$f->getDuration().'">
                        <input  name="language" type="hidden" value="'.$f->getLanguage().'">
                        <input  name="description" type="hidden" value="'.$f->getDescription().'">
                        <input type="submit" id="submit" value="Editar" name="edit_film" class="primary" />
                    </form> 
                </td> 
                <td> 
                    <form method="post" action="index.php?state=mf">
                        <input  name="id" type="hidden" value="'.$f->getId().'">
                        <input  name="tittle" type="hidden" value="'.$f->getTittle().'">
                        <input  name="duration" type="hidden" value="'.$f->getDuration().'">
                        <input  name="language" type="hidden" value="'.$f->getLanguage().'">
                        <input  name="description" type="hidden" value="'.$f->getDescription().'">
                        <input type="submit" id="submit" value="Eliminar" name="delete_film" class="primary" />
                    </form> 
                </td> 
                </tr>'; 
                } 
        echo'<tbody>
            </table>
            </div>';
	}*/
    function addFilm(){
        echo'<div class="column">
        <h2>Añadir pelicula</h2>
        <form method="post" action="index.php?state=mf">
            <div class="row">
            <fieldset id="film_form">
                <legend>Datos de pelicula</legend>
                <div>
                    <input type="text" name="tittle" id="tittle" placeholder="Título" />
                </div>
                <div>
                    <input type="number" name="duration" id="duration" placeholder="Duración" />
                </div>
                <div>
                    <input type="text" name="language" id="language" placeholder="Idioma" />
                </div>
                <div>
                <input type="text" name="description" id="description" placeholder="Descripción" />
            </div>
                </fieldset>
                <div class="actions"> 
                    <input type="submit" id="submit" value="Añadir pelicula" name="add_film" class="primary" />
                    <input type="reset" id="reset" value="Borrar" />       
                    </div>
                </div>
                </form>
                </div>';
    }
    function deleteFilm() {
        echo'<div class="column">
        <h2>Editar pelicula</h2>
        <form method="post" action="index.php?state=mf">
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
    function editFilm() {
        echo'<div class="column">
        <h2>Editar pelicula</h2>
        <form method="post" action="index.php?state=mf">
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

    // Logic Functions
       function confirmDelete() {
        $film = new FormFilm();
        $film->processesForm($_POST['id'],null,null,null,null,"del");
        $_SESSION['message'] = $film->getReply();
        header('Location: ../panel_admin/index.php?state=mf');
    }
    function confirmEdit() {
        $film = new FormFilm();
        $film->processesForm($_POST['id'], $_POST['tittle'], $_POST['duration'], $_POST['language'], $_POST['description'], "edit");
        $_SESSION['message']= $film->getReply();
        header('Location: ../panel_admin/index.php?state=mf');
    }
    function confirmAdd() {
        $film = new FormFilm();
        $film->processesForm(null, $_POST['tittle'], $_POST['duration'], $_POST['language'], $_POST['description'], "new");
        $_SESSION['message'] = $film->getReply();
        header('Location: ../panel_admin/index.php?state=mf');
    }


?>