<?php
	require('./includes/film_dto.php');	
    require('./includes/film_dao.php');	
	/*$f1 = new FilmDTO(1000,"Los vengadores",183,"español","");
	$f2 = new FilmDTO(2001,"Mecernarios",140,"español","");
	$f3 = new FilmDTO(3022,"Monster hunter",104,"español","");
	$f4 = new FilmDTO(4560,"Godzilla vs kong",113,"inglés","");
	$f5 = new FilmDTO(4260,"Tom y Jerry",131,"inglés","");
	$f6 = new FilmDTO(4606,"Pequeños Detalles",127,"inglés","");
	$film= array($f1, $f2, $f3, $f4,$f5,$f6);	*/						

    $bd = new FilmDAO("complucine");
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
        echo "
            <tr>
                <td>" . $f->getId() . "</td>
                <td>" . $f->getTittle() . "</td>
                <td>" . $f->getDuration() . "</td>
                <td>". $f->getLanguage() . "</td>
                <td>". $f->getDescription()."</td>
                <td> <button type=\"button\">Editar</button> </td> 
                </tr>"; 
                } 
        echo "<tbody>
        </table>\n";
	}
    function addFilm(){
        echo'<div class="column size">
        <h2>Añadir pelicula</h2>
        <form method="post" action="../panel_admin/manage_films/add_film.php">
            <div class="row">
            <fieldset id="film_form">
                <legend>Datos de pelicula</legend>
                <div>
                    <input type="text" name="title" id="title" value="" placeholder="Título" />
                </div>
                <div>
                    <input type="number" name="duration" id="duration" value="" placeholder="Duración" />
                </div>
                <div>
                    <input type="text" name="lenguage" id="language" value="" placeholder="Idioma" />
                </div>
                <div>
                <input type="text" name="lenguage" id="description" value="" placeholder="Descripción" />
            </div>
                </fieldset>
                <div class="actions"> 
                    <input type="submit" id="submit" value="Añadir pelicula" name="add_film" class="primary" />
                    <input type="reset" id="reset" value="Borrar" />       
                    </div>
                </div>
                </form>
                </div>'."\n";
        }
    
	drawFilms($bd->allFilmData());
	addFilm();
    

	?>