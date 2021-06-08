<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/includes/promotion_dao.php');
include_once('../assets/php/includes/promotion.php');
include_once('../assets/php/form.php');

class formDeletePromotion extends Form{
	//Constants:
	

	public function __construct() {
        $op = array("action" => "./?state=mp");
        parent::__construct('formEditPromotion', $op);
    }

	protected function generaCamposFormulario($datos, $errores = array()){
		$html ="";
        if (!isset($_SESSION['message'])) {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
		$errorId = self::createMensajeError($errores, 'id', 'span', array('class' => 'error'));
        //$errorTittle = self::createMensajeError($errores, 'tittle', 'span', array('class' => 'error'));
        //$errorDescription = self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
        //$errorCode = self::createMensajeError($errores, 'code', 'span', array('class' => 'error'));
		//$errorActive = self::createMensajeError($errores, 'active', 'span', array('class' => 'error'));
		//$errorImage = self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));

		$html .= '<div class="row">
		<h3>ELIMINAR PROMOCIÓN</h3>
						<fieldset id="promotion_form"><pre>'.$htmlErroresGlobales.'</pre>
                        <legend>¿Estás seguro de que quieres eliminar esta promocion?</legend>
                            <input type="hidden" name="id" value='.$_POST['id'].'/><pre>'.$errorId.'</pre>
							<p>Id: '.$_POST['id'].' </p>
                            <p>Nombre: '.$_POST['tittle'].'</p>
                            <p>Description:'.$_POST['description'].'</p>
                            <p>Codigo: '.$_POST['code'].'</p>
                            <p>Activa: '.$_POST['active'].'</p>			
					</fieldset>
					<div class="actions"> 
						<input type="submit" id="submit" value="Eliminar" name="delete_promotion" class="primary" />
						<input type="submit" id="submit" value="Cancelar" class="primary" />     
						</div>
					</div>
				</div>';
		}
        return $html;
    }

	protected function procesaFormulario($datos){
        $result = array();
        
        $id =  $this->test_input($_POST['id']) ?? null;
        if ( is_null($id)) {
			$result['id'] = "La promoción seleccionada no existe.";
		}
        
        if (count($result) === 0) {
        	$bd = new Promotion_DAO("complucine");

			
			$exist = $bd-> promotionData($id);
			if(mysqli_num_rows($exist) == 1){
				$bd->deletePromotion($id);
				$_SESSION['message'] = "<div class='row'>
										<div class='column side'></div>
										<div class='column middle'>
											<div class='code info'>
												<h1> Operacion realizada con exito </h1><hr />
												<p> Se ha eliminado la promocion correctamente en la base de datos.</p>
												<a href='../panel_admin/index.php?state=mp'><button>Cerrar Mensaje</button></a>
											</div>
										</div>
										<div class='column side'></div>
									</div>
									";
				//$result = './?state=mp';
			}
			else{
				
                $result[] = "La promocion seleccionada no existe.";
			}
			$exist->free();
		}
		return $result;
	}
}

?>