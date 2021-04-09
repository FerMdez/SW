<?php
	require('./includes/film_dto.php');	

	$f1 = new FilmDTO(1000,"Los vengadores",183,"español");
	$f2 = new FilmDTO(2001,"Mecernarios",140,"español");
	$f3 = new FilmDTO(3022,"Monster hunter",104,"español");
	$f4 = new FilmDTO(4560,"Godzilla vs kong",113,"inglés");
	$f5 = new FilmDTO(4260,"Tom y Jerry",131,"inglés");
	$f6 = new FilmDTO(4606,"Pequeños Detalles",127,"inglés");
	$film= array($f1, $f2, $f3, $f4,$f5,$f6);							

	function drawFilms($film){
						
	echo "
	<table class='alt'>
		<thead>
		<tr>
			<th>Id</th>
			<th>Título</th>
			<th>Duracion</th>
			<th>Idioma</th>
		</tr>
		</thead>
		<tbody>"; 
	foreach($film as $f){ 
	echo "
		<tr>
			<td>" . $f->getId() . "</td>
			<td>" . $f->getTittle() . "</td>
			<td>" . $f->getDuration() . "</td>
			<td>". $f->getLanguage() . "</td>
			 <td> <button type=\"button\">Editar</button> </td> 
			</tr>"; 
			} 
	echo "<tbody>
	</table>\n";
	}
	drawFilms($film);
	addFilm();
	function addFilm(){
	echo'<div class="column size">
	<h2>Añadir o modificar pelicula</h2>
	<form method="post" action="add_film.php">
		<div class="row">
		<fieldset id="film_form">
			<legend>Datos de pelicula</legend>
				<div class="_idfilm">
				<input type="text" name="idfilm" id="idfilm" value="" placeholder="IdPelicula" />
			</div>
			<div class="_name">
				<input type="text" name="title" id="title" value="" placeholder="Titulo" />
			</div>
			<div class="_address">
				<input type="number" name="duration" id="duration" value="" placeholder="Duracion" />
			</div>
			<div class="_phone_number">
				<input type="text" name="lenguage" id="lenguage" value="" placeholder="Idioma" />
			</div>
			</fieldset>
			<div class="actions"> 
				<input type="submit" id="submit" value="Añadir pelicula" class="primary" />
				<input type="reset" id="reset" value="Borrar" />       
				</div>
			</div>
			</form>
			</div>'."\n";
	}
	?>	
