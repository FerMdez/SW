<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/common/manager_dao.php');
include_once('../assets/php/common/manager.php');
include_once('../assets/php/form.php');

class formDeleteManager extends Form{
	//Constants:
	const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

	public function __construct() {
        $options = array("action" => "./?state=mg");
        parent::__construct('formDeleteManager', $options);
    }

	protected function generaCamposFormulario($datos, $errores = array()){
       

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorId = self::createMensajeError($errores, 'id', 'span', array('class' => 'error'));
        //$errorIdCinema = self::createMensajeError($errores, 'idcinema', 'span', array('class' => 'error'));

		$html = '<div class="row">
                    <fieldset id="promotion_form"><pre>'.$htmlErroresGlobales.'</pre>
                        <legend>¿Estás seguro de que quieres eliminar este gerente?</legend>
                        <input type="hidden" name="id" value='.$_POST['id'].'/>
                        <p>Id: '.$_POST['id'].' </p>
                        <p>IdCinema: '.$_POST['idcinema'].' </p>
                        <p>Nombre: '.$_POST['username'].' </p>
                        <p>Email: '.$_POST['email'].' </p>
                        <p>Rol: '.$_POST['rol'].' </p>
                    </fieldset>
                    <div class="actions"> 
                        <input type="submit" id="submit" value="Eliminar" name="delete_manager" class="primary" />
                        <input type="submit" id="submit" value="Cancelar"  class="primary" />
                    </div>
                </div>';

        return $html;
    }

	protected function procesaFormulario($datos){
        $result = array();
        
        $id = $this->test_input($datos['id']) ?? null;
        if (is_null($id) ) {
            $result['id'] = "ERROR. No existe un manager con ese ID";
        }
        
        if (count($result) === 0) {
            $bd = new Manager_DAO('complucine');
            $exist = $bd-> GetManager($id);
            if( mysqli_num_rows($exist) == 1){
                $bd->deleteManager($id);
                $_SESSION['message'] = "<div class='row'>
                                        <div class='column side'></div>
                                        <div class='column middle'>
                                            <div class='code info'>
                                                <h1> Operacion realizada con exito </h1><hr />
                                                <p> Se ha eliminado el gerente correctamente en la base de datos.</p>
                                                <a href='../panel_admin/index.php?state=mg'><button>Cerrar Mensaje</button></a>
                                            </div>
                                        <div class='column side'></div>
                                    </div>";
                $result = './?state=mg';
            }
            else{
                $result[] = "ERROR. No existe un manager con ese ID";
            }
            
            	
		}
		return $result;
	}

    protected function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }


}

?>