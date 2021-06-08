<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/includes/film_dao.php');
include_once('../assets/php/includes/film.php');
include_once('../assets/php/form.php');

class formAddFilm extends Form{
	//Constants:
	const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 
	const EXTENSIONS = array('gif','jpg','jpe','jpeg','png');

	public function __construct() {
        $options = array("action" => "./?state=mf&option=a", 'enctype' => 'multipart/form-data');
        parent::__construct('formAddFilm', $options);
    }

	protected function generaCamposFormulario($datos, $errores = array()){
       

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorTittle = self::createMensajeError($errores, 'tittle', 'span', array('class' => 'error'));
        $errorDuration = self::createMensajeError($errores, 'duration', 'span', array('class' => 'error'));
        $errorLanguage = self::createMensajeError($errores, 'language', 'span', array('class' => 'error'));
		$errorDescription = self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
		$errorImage = self::createMensajeError($errores, 'img', 'span', array('class' => 'error'));

		$html = '<div class="row">
					<fieldset id="film_form"><pre>'.$htmlErroresGlobales.'</pre>
						<legend>AÑADIR PELÍCULA</legend>
							<input type="text" name="tittle" id="tittle" placeholder="Título" required/><pre>'.$errorTittle.'</pre>
							<input type="number" name="duration" id="duration" placeholder="Duración" required/><pre>'.$errorDuration.'</pre>
							<input type="text" name="language" id="language" placeholder="Idioma" required/><pre>'.$errorLanguage.'</pre>
							<input type="text" name="description" id="description" placeholder="Descripción" required/><pre>'.$errorDescription.'</pre>
							<div class="file">Imagen promocional:<input type="file" name="archivo" id="file" placeholder="Imagen promocional" /></div><pre>'.$errorImage.'</pre>
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
		
        $t = $this->test_input($datos['tittle']) ?? null;
		$tittle = strtolower(str_replace(" ", "_", $t));
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
			$exist = $bd-> GetFilm($tittle,$language);
			if(mysqli_num_rows($exist) != 0){
				$result[] = "Ya existe una nueva pelicula con el mismo titulo e idioma.";
			}
			else{
				$ok = count($_FILES) == 1 && $_FILES['archivo']['error'] == UPLOAD_ERR_OK;
				if ( $ok ) {
				$archivo = $_FILES['archivo'];
				$nombre = $_FILES['archivo']['name'];
				//1.a) Valida el nombre del archivo 
				$ok = $this->check_file_uploaded_name($nombre) && $this->check_file_uploaded_length($nombre) ;
				
				// 1.b) Sanitiza el nombre del archivo 
				//$ok = $this->sanitize_file_uploaded_name($nombre);
				//
				
				// 1.c) Utilizar un id de la base de datos como nombre de archivo 
			
				// 2. comprueba si la extensión está permitida
				$ok = $ok && in_array(pathinfo($nombre, PATHINFO_EXTENSION), self::EXTENSIONS);
			
				// 3. comprueba el tipo mime del archivo correspode a una imagen image
				$finfo = new \finfo(FILEINFO_MIME_TYPE);
				$mimeType = $finfo->file($_FILES['archivo']['tmp_name']);
				$ok = preg_match('/image\/*./', $mimeType);
				//finfo_close($finfo);
				
				if ( $ok ) {
					$tmp_name = $_FILES['archivo']['tmp_name'];
					$nombreBd = strtolower(str_replace(" ", "_", $tittle)).".".pathinfo($nombre, PATHINFO_EXTENSION);
					if ( !move_uploaded_file($tmp_name, "../img/films/{$nombreBd}") ) {
					$result['img'] = 'Error al mover el archivo';
					}
			
					//if ( !copy("../img/tmp/{$nombre}", "/{$nombre}") ) {
					//  $result['img'] = 'Error al mover el archivo';
					//}
					//$nombreBd = str_replace("_", " ", $nombre);
					$bd->createFilm(null, $tittle,$duration,$language,$description, $nombreBd); //Null hasta tener $nombre
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
			
				}else {
					$result['img'] = 'El archivo tiene un nombre o tipo no soportado';
				}
				} else {
				$result['img'] = 'Error al subir el archivo.';
				}

			}
			$exist->free();
		}
		return $result;
	}

	private function check_file_uploaded_name ($filename) {
		return (bool) ((mb_ereg_match('/^[0-9A-Z-_\.]+$/i',$filename) === 1) ? true : false );
	}
	private function check_file_uploaded_length ($filename) {
		return (bool) ((mb_strlen($filename,'UTF-8') < 250) ? true : false);
	}

}
?>