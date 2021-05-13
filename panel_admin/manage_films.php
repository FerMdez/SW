<?php

    //General Config File:
    include_once('../assets/php/config.php');	
    include_once('./includes/formFilm.php');	
    require_once($prefix.'assets/php/common/film_dao.php');
 
   
    // View functions
    function addFilm(){
        echo'<div class="column side"></div>
                <div class="column middle">
                    <h2>Añadir pelicula</h2>
                    <form method="post" enctype="multipart/form-data" action="index.php?state=mf">
                        <div class="row">
                            <fieldset id="film_form">
                            <legend>Datos de pelicula</legend>
                                <input type="text" name="tittle" id="tittle" placeholder="Título" />
                                <input type="number" name="duration" id="duration" placeholder="Duración" />
                                <input type="text" name="language" id="language" placeholder="Idioma" />
                                <input type="text" name="description" id="description" placeholder="Descripción" />
                                <div class="file">Imagen promocional:<input type="file" name="file" id="file" placeholder="Imagen promocional" /></div>
                            </fieldset>
                            <div class="actions"> 
                                <input type="submit" id="submit" value="Añadir pelicula" name="add_film" class="primary" />
                                <input type="reset" id="reset" value="Borrar" />       
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="column side"></div>
                ';
    }
    function deleteFilm() {
        echo'<div class="column side"></div>
                <div class="column middle">
                    <h2>Eliminar pelicula</h2>
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
                </div>
                <div class="column side"></div>
                ';
    }
    function editFilm() {
        echo'<div class="column side"></div>
                <div class="column middle">
                <h2>Editar pelicula</h2>
                <form method="post" enctype="multipart/form-data" action="index.php?state=mf">
                    <div class="row">
                        <fieldset id="film_form">
                        <legend>Datos de pelicula</legend>
                            <input type="hidden" name="id" value='.$_POST['id'].'/>
                            <input type="text" name="tittle" value="'.$_POST['tittle'].'" />
                            <input type="number" name="duration" id="duration" value='.$_POST['duration'].' />
                            <input type="text" name="language" id="language" value="'.$_POST['language'].'" />
                            <input type="text" name="description" id="description" value="'.$_POST['description'].'"/>
                            <div class="file">Imagen promocional:<input type="file" name="file" id="file" placeholder="Imagen promocional" /></div>
                        </fieldset>
                        <div class="actions"> 
                            <input type="submit" id="submit" value="Editar" name="confirm_edit_film" class="primary" />
                            <input type="reset" id="reset" value="Borrar" />       
                            </div>
                        </div>
                    </form>
                </div>
                <div class="column side"></div>
                ';
    }

    // Logic Functions
       function confirmDelete() {
        $film = new FormFilm();
        $film->processesForm($_POST['id'],null,null,null,null,null,"del");
        $_SESSION['message'] = $film->getReply();
        header('Location: ../panel_admin/index.php?state=mf');
    }
    function confirmEdit() {
        $film = new FormFilm();
        $film->processesForm($_POST['id'], $_POST['tittle'], $_POST['duration'], $_POST['language'], $_POST['description'], $_POST['file'], "edit");
        $_SESSION['message']= $film->getReply();
        header('Location: ../panel_admin/index.php?state=mf');
    }
    function confirmAdd() {
        $film = new FormFilm();
        $film->processesForm(null, $_POST['tittle'], $_POST['duration'], $_POST['language'], $_POST['description'], $_POST['file'], "new");
        $_SESSION['message'] = $film->getReply();
        header('Location: ../panel_admin/index.php?state=mf');
    }


?>