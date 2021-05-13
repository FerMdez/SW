<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/common/cinema_dao.php');
include_once('../assets/php/common/cinema.php');
include_once('../assets/php/form.php');

class formDeleteCinema extends Form{

    public function __construct(){
        $op = array("action"=>"./?state=mc");
        parent::__construct('formAddCinema',$op);
    } 

    protected function generaCamposFormulario($datos,$errores=array()){

        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorId = self::createMensajeError($errores, 'id', 'span', array('class' => 'error'));

        $html = '<div class="column side"></div>
                    <fieldset id = "cinema_form">'.$htmlErroresGlobales.'</pre>
                    <legend>¿Estás seguro de que quieres eliminar este cine?</legend>
					<input type="hidden" name="id" value='.$_POST['id'].'/>
						<p>Name: '.$_POST['name'].' </p>
						<p>Dirección: '.$_POST['direction'].' </p>
						<p>Teléfono: '.$_POST['phone'].' </p>
                    </fieldset>
                    <div class="actions"> 
                        <input type="submit" id="submit" value="Eliminar" name="delete_cinema" class="primary" />
                        <input type="submit" id="submit" value="Cancelar" class="primary" />
                    </div>
                </div>  ';
         return $html;
    }           
    
     //Process form:
	public function procesaFormulario($datos) {
        $result =array();
        
        $id = $this->test_input($datos['id'])??null;

        if(is_null($id)){
            $result['id']= "El nombre no es válido";
        }
        
        if(count($result)===0){
		    $bd = new Cinema_DAO('complucine');
            $exist = $bd -> cinemaData($id);
		    if(mysqli_num_rows($exist)==1){
                $bd->deleteCinema($id);
                $_SESSION['message'] = "<div class='row'>
                                        <div class='column side'></div>
                                        <div class='column middle'>
                                            <div class='code info'>
                                                <h1> Operacion realizada con exito </h1><hr />
                                                <p> Se ha eliminado el cine correctamente en la base de datos.</p>
                                                <a href='../panel_admin/index.php?state=mc'><button>Cerrar Mensaje</button></a>
                                            </div>
                                        </div>
                                        <div class='column side'></div>
                                    </div>
                                    ";
                $result = './?state=mc';                    
            }	
            $exist->free();
            }
            else{
                $result[] = "El cine seleccionado no existe.";	
		}
        return $result;	
	}

	protected function test_input($input){
		return htmlspecialchars(trim(strip_tags($input)));
	}
}

?>