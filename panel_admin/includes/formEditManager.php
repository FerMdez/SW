<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/common/manager_dao.php');
include_once('../assets/php/common/manager.php');
include_once('../assets/php/common/cinema_dao.php');
include_once('../assets/php/form.php');

class formEditManager extends Form{
	//Constants:
	const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

	public function __construct() {
        $options = array("action" => "./?state=mg");
        parent::__construct('formEditManager', $options);
    }

	protected function generaCamposFormulario($datos, $errores = array()){
       

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        //$errorId = self::createMensajeError($errores, 'id', 'span', array('class' => 'error'));
        //$errorIdCinema = self::createMensajeError($errores, 'idcinema', 'span', array('class' => 'error'));

		$html = '<div class="row">
                    <h1>EDITAR GERENTE ID:'.$_POST['id'].'</h1>
                    <fieldset id="film_form"><pre>'.$htmlErroresGlobales.'</pre>
                    <legend>Selecciona cine.</legend>
                    <input type="hidden" name="id" value='.$_POST['id'].'/>'
                    .$this->showCinemas().
                    '</fieldset>
                <div class="actions"> 
                        <input type="submit" id="submit" value="Seleccionar" name="edit_manager" class="primary" />
                        <input type="reset" id="reset" value="Borrar" />       
                        </div>
                </div>
                </div>';

        return $html;
    }

	protected function procesaFormulario($datos){
        $result = array();
        
        $id = $this->test_input($datos['id']) ?? null;
        if (is_null($id) ) {
            $result[] = "ERROR. No existe un usuario con ese ID";
        }

        $idcinema = $this->test_input($datos['idcinema']) ?? null;
		//||!mb_ereg_match(self::HTML5_EMAIL_REGEXP, $duration) 
        if (is_null($idcinema)) {
            $result[] = "ERROR. No existe un cine con ese ID";
        }
        
        
        if (count($result) === 0) {
        	$bd = new Manager_DAO("complucine");
            $exist = $bd-> GetManager($id);
            if( mysqli_num_rows($exist) == 1){
                $bd->editManager($id,$idcinema);
                $_SESSION['message'] = "<div class='row'>
                                        <div class='column side'></div>
                                        <div class='column middle'>
                                            <div class='code info'>
                                                <h1> Operacion realizada con exito </h1><hr />
                                                <p> Se ha editado el gerente correctamente en la base de datos.</p>
                                                <a href='../panel_admin/index.php?state=mg'><button>Cerrar Mensaje</button></a>
                                            </div>
                                        <div class='column side'></div>
                                    </div>";
                $result = './?state=mg';           
                
            }
            else{
                $result[] = "ERROR. No existe un cine con ese ID";
            }
            $exist->free();
            
            	
		}
		return $result;
	}

    protected function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }


    private function showCinemas() {
        $cine = new Cinema_DAO("complucine");
        $cinemas = $cine->allCinemaData();
        $ids = array();
        $names = array();
        $directions = array();
        $phones = array();

        foreach($cinemas as $key => $value){
            $ids[$key] = $value->getId();
            $names[$key] = $value->getName();
            $directions[$key] = $value->getDirection();
            $phones[$key] = $value->getPhone();
        }
        $html = '';
        for($i = 0; $i < count($cinemas); $i++){
            $html.= '
            <input type="radio" name="idcinema" value='.$ids[$i].' >  <label> '.$ids[$i].', '.$names[$i].'
            </label>
            ';
        }
        return $html;
    }


}

?>