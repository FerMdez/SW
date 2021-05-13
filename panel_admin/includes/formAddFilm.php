<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/common/film_dao.php');
include_once('../assets/php/common/film.php');
include_once('../assets/php/form.php');

class formAddFilm extends Form{
	//Constants:
	const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

	public function __construct() {
        $options = array("action" => "./?state=mf");
        parent::__construct('formAddFilm', $options);
    }

	protected function generaCamposFormulario($datos, $errores = array()){
       

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorTittle = self::createMensajeError($errores, 'tittle', 'span', array('class' => 'error'));
        $errorDuration = self::createMensajeError($errores, 'duration', 'span', array('class' => 'error'));
        $errorLanguage = self::createMensajeError($errores, 'language', 'span', array('class' => 'error'));
		$errorDescription = self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
		//$errorImage = self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));

		$html = '<div class="row">
					<fieldset id="film_form"><pre>'.$htmlErroresGlobales.'</pre>
						<legend>AÑADIR PELÍCULA</legend>
							<input type="text" name="tittle" id="tittle" placeholder="Título" required/><pre>'.$errorTittle.'</pre>
							<input type="number" name="duration" id="duration" placeholder="Duración" required/><pre>'.$errorDuration.'</pre>
							<input type="text" name="language" id="language" placeholder="Idioma" required/><pre>'.$errorLanguage.'</pre>
							<input type="text" name="description" id="description" placeholder="Descripción" required/><pre>'.$errorDescription.'</pre>
							<div class="file">Imagen promocional:<input type="file" name="file" id="file" placeholder="Imagen promocional" /></div>
					</fieldset>
					<div class="actions"> 
						<input type="submit" id="submit" value="Añadir pelicula" class="primary" />
						<input type="reset" id="reset" value="Borrar" />       
						</div>
					</div>
				</div>';

        return $html;
    }

	protected function procesaFormulario($datos){
        $result = array();
        
        $tittle = $this->test_input($datos['tittle']) ?? null;
		//|| !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $tittle) 
        if ( empty($tittle) ) {
            $result['tittle'] = "El título no es válido";
        }

        $duration = $this->test_input($datos['duration']) ?? null;
		//||!mb_ereg_match(self::HTML5_EMAIL_REGEXP, $duration) 
        if ( empty($duration) || $duration <0) {
            $result['duration'] = "La duración no es válida";
        }
        
        $language = $this->test_input($datos['language']) ?? null;
		//|| !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $language)
        if ( empty($language)  ) {
            $result['language'] = "El idioma no es válido";
        }

		$description = $this->test_input($datos['description']) ?? null;
		//|| !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $description) 
        if ( empty($language)) {
            $result['language'] = "La descripcion no es válida";
        }
        
        if (count($result) === 0) {
        	$bd = new Film_DAO("complucine");

			//FALTARIA SUBIR LA IMAGEN
			$exist = $bd-> GetFilm($tittle,$language);
			if(mysqli_num_rows($exist) != 0){
				$result[] = "Ya existe una nueva pelicula con el mismo titulo e idioma.";
			}
			else{
				$bd->createFilm(null, $tittle,$duration,$language,$description);
				$_SESSION['message'] = "<div class='row'>
										<div class='column side'></div>
										<div class='column middle'>
											<div class='code info'>
												<h1> Operacion realizada con exito </h1><hr />
												<p> Se ha añadido la pelicula correctamente en la base de datos.</p>
												<a href='../panel_admin/index.php?state=mf'><button>Cerrar Mensaje</button></a>
											</div>
										</div>
										<div class='column side'></div>
									</div>
									";
				$result = './?state=mf';

			}
			$exist->free();
		}
		return $result;
	}

    protected function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }


}

?>