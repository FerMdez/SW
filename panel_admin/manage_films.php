<?php
	require('./includes/film_dto.php');	
    require('./includes/formFilm.php');	
	/*$f1 = new FilmDTO(1000,"Los vengadores",183,"español","");
	$f2 = new FilmDTO(2001,"Mecernarios",140,"español","");
	$f3 = new FilmDTO(3022,"Monster hunter",104,"español","");
	$f4 = new FilmDTO(4560,"Godzilla vs kong",113,"inglés","");
	$f5 = new FilmDTO(4260,"Tom y Jerry",131,"inglés","");
	$f6 = new FilmDTO(4606,"Pequeños Detalles",127,"inglés","");
	$film= array($f1, $f2, $f3, $f4,$f5,$f6);	*/

    $film = new FormFilm();	
    $film->processesForm(null, null, null, null, null, "show");
    
	function drawFilms($films){	
        			
        echo "
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
                    <form method="post" action="./index.php?state=ef">
                        <input  name="id" type="hidden" value="'.$f->getId().'">
                        <input  name="tittle" type="hidden" value="'.$f->getTittle().'">
                        <input  name="duration" type="hidden" value="'.$f->getDuration().'">
                        <input  name="language" type="hidden" value="'.$f->getLanguage().'">
                        <input  name="description" type="hidden" value="'.$f->getDescription().'">
                        <input type="submit" id="submit" value="Editar" name="edit_film" class="primary" />
                    </form> 
                </td> 
                <td> 
                    <form method="post" action="./index.php?state=df">
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
            </table>';
	}
    function addFilm(){
        echo'<div class="column size">
        <h2>Añadir pelicula</h2>
        <form method="post" action="add_film.php">
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
    function showmessage() {
        if(isset($_SESSION['message'])){
            echo '<div>
                    <h3>'.$_SESSION["message"].'</h3>
                </div>';
            unset($_SESSION['message']);
        }
    }
    showmessage();
	drawFilms($film->getReply());
	addFilm();

?>