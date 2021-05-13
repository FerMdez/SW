<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/common/promotion_dao.php');
include_once('../assets/php/common/promotion.php');
include_once('../assets/php/form.php');

class formAddPromotion extends Form{
	//Constants:
	

	public function __construct() {
        $op = array("action" => "./?state=mp");
        parent::__construct('formAddPromotion', $op);
    }

	protected function generaCamposFormulario($datos, $errores = array()){
       

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorTittle = self::createMensajeError($errores, 'tittle', 'span', array('class' => 'error'));
        $errorDescription = self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
        $errorCode = self::createMensajeError($errores, 'code', 'span', array('class' => 'error'));
		$errorActive = self::createMensajeError($errores, 'active', 'span', array('class' => 'error'));
		//$errorImage = self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));

		$html = '<div class="row">
					<fieldset id="promotion_form"><pre>'.$htmlErroresGlobales.'</pre>
						<legend>AÑADIR PROMOCIÓN</legend>
							<input type="text" name="tittle" id="tittle" placeholder="Título" required/><pre>'.$errorTittle.'</pre>
							<input type="text" name="description" id="description" placeholder="Descripción" required/><pre>'.$errorDescription.'</pre>
							<input type="text" name="code" id="code" placeholder="Codigo" required/><pre>'.$errorCode.'</pre>
							<input type="text" name="active" id="active" placeholder="Activo" required/><pre>'.$errorActive.'</pre>
							<div class="file">Imagen promocional:<input type="file" name="file" id="file" placeholder="Imagen promocional" /></div>
					</fieldset>
					<div class="actions"> 
						<input type="submit" id="submit" value="Añadir promocion" name="add_promotion" class="primary" />
						<input type="reset" id="reset" value="Borrar" />       
						</div>
					</div>
				</div>';

        return $html;
    }

	protected function procesaFormulario($datos){
        $result = array();
        
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
        	$bd = new Pomotion_DAO("complucine");

			//FALTARIA SUBIR LA IMAGEN
			$exist = $bd-> GetPromotion($code);
			if(mysqli_num_rows($exist) != 0){
				$result[] = "Ya existe una nueva promocion con el mismo codigo.";
			}
			else{
				$bd->createPromotion(null, $tittle,$description,$code,$active);
				$_SESSION['message'] = "<div class='row'>
										<div class='column side'></div>
										<div class='column middle'>
											<div class='code info'>
												<h1> Operacion realizada con exito </h1><hr />
												<p> Se ha añadido la promocion correctamente en la base de datos.</p>
												<a href='../panel_admin/index.php?state=mp'><button>Cerrar Mensaje</button></a>
											</div>
										</div>
										<div class='column side'></div>
									</div>
									";
				$result = './?state=mp';

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