<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/common/film_dao.php');
include_once('../assets/php/common/film.php');
include_once('../assets/php/form.php');

class formDeleteFilm extends Form{
	//Constants:
	const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

	public function __construct() {
        $options = array("action" => "./?state=mf");
        parent::__construct('formDeleteFilm', $options);
    }

	protected function generaCamposFormulario($datos, $errores = array()){
       

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
		$errorId = self::createMensajeError($errores, 'id', 'span', array('class' => 'error'));
        //$errorTittle = self::createMensajeError($errores, 'tittle', 'span', array('class' => 'error'));
        //$errorDuration = self::createMensajeError($errores, 'duration', 'span', array('class' => 'error'));
        //$errorLanguage = self::createMensajeError($errores, 'language', 'span', array('class' => 'error'));
		//$errorDescription = self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
		//$errorImage = self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));

		$html = '<div class="row">
				<fieldset id="film_form"><pre>'.$htmlErroresGlobales.'</pre>
					<legend>¿Estás seguro de que quieres eliminar esta pelicula?</legend>
					<input type="hidden" name="id" value='.$_POST['id'].'/><pre>'.$errorId.'</pre>
						<p>Id: '.$_POST['id'].' </p>
						<p>Título: '.$_POST['tittle'].' </p>
						<p>Duración: '.$_POST['duration'].' </p>
						<p>Idioma: '.$_POST['language'].' </p>
						<p>Descripción: '.$_POST['description'].' </p>
				</fieldset>
				<div class="actions"> 
					<input type="submit" id="submit" value="Eliminar" name="delete_film" class="primary" />
					<input type="submit" id="submit" value="Cancelar" class="primary" />
				</div>
		</div>';

        return $html;
    }

	protected function procesaFormulario($datos){
        $result = array();
        $id =  $this->test_input($datos['id']) ?? null;
		if ( is_null($id)) {
			$result['id'] = "La pelicula seleccionada no existe.";
		}
        
        if (count($result) === 0) {
        	$bd = new Film_DAO("complucine");
			$exist = $bd-> FilmData($id);
			if( mysqli_num_rows($exist) == 1){
				$bd->deleteFilm($id);
				$_SESSION['message'] = "<div class='row'>
										<div class='column side'></div>
										<div class='column middle'>
										<div class='code info'>
										<h1> Operacion realizada con exito </h1><hr />
										<p> Se ha eliminado la pelicula correctamente en la base de datos.</p>
										<a href='../panel_admin/index.php?state=mf'><button>Cerrar Mensaje</button></a>
										</div>
										</div>
										<div class='column side'></div>
										</div>
					";
					$result = './?state=mf';
			}
			else{
				$result[] = "La pelicula seleccionada no existe.";
			}

			$exist->free();
		}
		return $result;
	}


}

?>