<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/includes/promotion_dao.php');
include_once('../assets/php/includes/promotion.php');
include_once('../assets/php/form.php');

class formEditPromotion extends Form{
	//Constants:
	//Constants:
	const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 
    const EXTENSIONS = array('gif','jpg','jpe','jpeg','png');

    public function __construct() {
        $options = array("action" => "./?state=mp", 'enctype' => 'multipart/form-data');
        parent::__construct('formEditPromotion', $options);
    }

	protected function generaCamposFormulario($datos, $errores = array()){
       

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
		$errorId = self::createMensajeError($errores, 'id', 'span', array('class' => 'error'));
        $errorTittle = self::createMensajeError($errores, 'tittle', 'span', array('class' => 'error'));
        $errorDescription = self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
        $errorCode = self::createMensajeError($errores, 'code', 'span', array('class' => 'error'));
		$errorActive = self::createMensajeError($errores, 'active', 'span', array('class' => 'error'));
		$errorImg = self::createMensajeError($errores, 'img', 'span', array('class' => 'error'));

		$html = '<div class="row">
					<fieldset id="promotion_form"><pre>'.$htmlErroresGlobales.'</pre>
                    <fieldset id="film_form">
                        <legend>Datos de promocion</legend>
                            <input type="hidden" name="id" value='.$_POST['id'].'/>
							<input type="text" name="tittle" id="tittle"value="'.$_POST['tittle'].'"required/><pre>'.$errorTittle.'</pre>
							<input type="text" name="description" id="description" value="'.$_POST['description'].'" required/><pre>'.$errorDescription.'</pre>
							<input type="text" name="code" id="code" value="'.$_POST['code'].'" required/><pre>'.$errorCode.'</pre>
							<input type="text" name="active" id="active" value="'.$_POST['active'].'"required/><pre>'.$errorActive.'</pre>
							<div class="file">Imagen promocional:<input type="file" name="archivo" id="file" placeholder="Imagen promocional" /><pre>'.$errorImg.'</pre></div>
					</fieldset>
					<div class="actions"> 
						<input type="submit" id="submit" value="Editar promocion" name="edit_promotion" class="primary" />
						<input type="reset" id="reset" value="Borrar" />       
						</div>
					</div>
				</div>';

        return $html;
    }

	protected function procesaFormulario($datos){
        $result = array();
        
        $id =  $this->test_input($_POST['id']) ?? null;
        if (is_null($id)) {
			$result['id'] = "La promoción seleccionada no existe.";
		}

		$t = $this->test_input($datos['tittle']) ?? null;
		$tittle = strtolower(str_replace(" ", "_", $t));
        if ( empty($tittle) ) {
            $result['tittle'] = "El título no es válido";
        }

        $description = $this->test_input($datos['description']) ?? null;

        if ( empty($description)) {
            $result['description'] = "La descripcion no es válida";
        }
        
        $code = $this->test_input($datos['code']) ?? null;

        if ( empty($code)  ) {
            $result['code'] = "El idioma no es válido";
        }

		$active = $this->test_input($datos['active']) ?? null;
		//|| !mb_ereg_match(self::HTML5_EMAIL_REGEXP, $description) 
        if ( $active>1 ||$active<0 ) {
            $result['active'] = "La descripcion no es válida";
        }
        
        if (count($result) === 0) {
        	$bd = new Promotion_DAO("complucine");

			$exist = $bd-> promotionData($id);
			if(mysqli_num_rows($exist) == 1){
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
				finfo_close($finfo);
				
				if ( $ok ) {
					$tmp_name = $_FILES['archivo']['tmp_name'];
					$nombreBd = strtolower(str_replace(" ", "_", $tittle)).".".pathinfo($nombre, PATHINFO_EXTENSION);
					if ( !move_uploaded_file($tmp_name, "../img/promos/{$nombreBd}") ) {
					$result['img'] = 'Error al mover el archivo';
					}
			
					//if ( !copy("../img/tmp/{$nombre}", "/{$nombre}") ) {
					//  $result['img'] = 'Error al mover el archivo';
					//}
					//$nombreBd = str_replace("_", " ", $nombre);
				   $bd->editPromotion($id, $tittle,$description,$code,$active, $nombreBd);
				   $_SESSION['message'] = "<div class='row'>
											<div class='column side'></div>
											<div class='column middle'>
												<div class='code info'>
													<h1> Operacion realizada con exito </h1><hr />
													<p> Se ha modificado la promocion correctamente en la base de datos.</p>
													<a href='../panel_admin/index.php?state=mp'><button>Cerrar Mensaje</button></a>
												</div>
											</div>
											<div class='column side'></div>
											</div>
											";
					$result = './?state=mp';
			
				}else {
					$result['img'] = 'El archivo tiene un nombre o tipo no soportado';
				}
				} else {
				   $bd->editPromotionNoImg($id, $tittle,$description,$code,$active);
				   $_SESSION['message'] = "<div class='row'>
											<div class='column side'></div>
											<div class='column middle'>
												<div class='code info'>
													<h1> Operacion realizada con exito </h1><hr />
													<p> Se ha modificado la promocion correctamente en la base de datos.</p>
													<a href='../panel_admin/index.php?state=mp'><button>Cerrar Mensaje</button></a>
												</div>
											</div>
											<div class='column side'></div>
											</div>
											";
					$result = './?state=mp';
				}
			}
			else{
				
                $result[] =  "La promocion seleccionada no existe.";
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