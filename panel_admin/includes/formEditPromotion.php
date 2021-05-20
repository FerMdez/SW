<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/includes/promotion_dao.php');
include_once('../assets/php/includes/promotion.php');
include_once('../assets/php/form.php');

class formEditPromotion extends Form{
	//Constants:
	

	public function __construct() {
        $op = array("action" => "./?state=mp");
        parent::__construct('formEditPromotion', $op);
    }

	protected function generaCamposFormulario($datos, $errores = array()){
       

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
		$errorId = self::createMensajeError($errores, 'id', 'span', array('class' => 'error'));
        $errorTittle = self::createMensajeError($errores, 'tittle', 'span', array('class' => 'error'));
        $errorDescription = self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
        $errorCode = self::createMensajeError($errores, 'code', 'span', array('class' => 'error'));
		$errorActive = self::createMensajeError($errores, 'active', 'span', array('class' => 'error'));
		//$errorImage = self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));

		$html = '<div class="row">
					<fieldset id="promotion_form"><pre>'.$htmlErroresGlobales.'</pre>
                    <fieldset id="film_form">
                        <legend>Datos de promocion</legend>
                            <input type="hidden" name="id" value='.$_POST['id'].'/>
							<input type="text" name="tittle" id="tittle"value="'.$_POST['tittle'].'"required/><pre>'.$errorTittle.'</pre>
							<input type="text" name="description" id="description" value="'.$_POST['description'].'" required/><pre>'.$errorDescription.'</pre>
							<input type="text" name="code" id="code" value="'.$_POST['code'].'" required/><pre>'.$errorCode.'</pre>
							<input type="text" name="active" id="active" value="'.$_POST['active'].'"required/><pre>'.$errorActive.'</pre>
							<div class="file">Imagen promocional:<input type="file" name="file" id="file" placeholder="Imagen promocional" /></div>
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

        $tittle = $this->test_input($datos['tittle']) ?? null;

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

			//FALTARIA SUBIR LA IMAGEN
			$exist = $bd-> promotionData($id);
			if(mysqli_num_rows($exist) == 1){
				$bd->editPromotion($id, $tittle,$description,$code,$active);
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
			else{
				
                $result[] =  "La promocion seleccionada no existe.";
			}
			$exist->free();
		}
		return $result;
	}


}

?>