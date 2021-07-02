<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/includes/cinema_dao.php');
include_once('../assets/php/includes/cinema.php');
include_once('../assets/php/form.php');

class formEditCinema extends Form{

    public function __construct(){
        $op = array("action"=>"./?state=mc");
        parent::__construct('formAddCinema',$op);
    } 

    protected function generaCamposFormulario($datos,$errores=array()){
        $html ="";
        if(!isset($_SESSION['message'])) {
            $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
            $errorId= self::createMensajeError($errores,'id','span',array('class'=>'error'));
            $errorName = self::createMensajeError($errores,'name','span',array('class'=>'error'));
            $errorDirection = self::createMensajeError($errores,'direction','span',array('class'=>'error'));
            $errrorPhone = self ::createMensajeError($errores,'phone',array('class'=>'error'));

            $html .= '<div class="row">
                                <fieldset id="film_form"><pre>'.$htmlErroresGlobales.'</pre>
                                <legend>Datos de cine </legend>  
                                <input type="hidden" name="id" value='.$_POST['id'].'/>                 
                                <input type="text" name="name" value="'.$_POST['name'].'" required/><pre>'.$errorName.'</pre>
                                <input type="text" name="direction" value="'.$_POST['direction'].'"required/><pre>'.$errorDirection.'</pre>
                                <input type="text" name="phone"  value="'.$_POST['phone'].'"required/><pre>'.$errrorPhone.'</pre>
                            </fieldset>
                                <div class="actions"> 
                                    <input type="submit" id="submit" value="Editar" name="edit_cinema" class="primary" />
                                    <input type="reset" id="reset" value="Borrar" />       
                                </div>
                            </div>
                        </div>
                    </div>  ';
        }

        return $html;
    }           
    
     //Process form:
	public function procesaFormulario($datos) {
        $result =array();
        
        
        $id =  $this->test_input($datos['id']) ?? null;
       // if (is_null($id)) {
		//	$result['id'] = "El cine seleccionado no existe.";
		//}

        $name = $this->test_input($datos['name'])??null;
        
        if(empty($name)){
            $result['name']= "El nombre no es válido";
        }
        
        $direction = $this->test_input($datos['direction']) ?? null;

        if(empty($direction)){
            $result['direction'] = "La dirección no es valida";
        }

        $phone = $this -> test_input($datos['phone']) ?? null;

        if(empty($phone)){
            $result['phone'] = "El teléfono no es valido";
        }
	
        if(count($result)===0){
		$bd = new Cinema_DAO('complucine');
        $exist = $bd -> existCinema($id);
		    if(mysqli_num_rows($exist)==1){
                $bd->editCinema($id,$name,$direction,$phone);
                $_SESSION['message'] = "<div class='row'>
                                        <div class='column side'></div>
                                        <div class='column middle'>
                                            <div class='code info'>
                                                <h1> Operacion realizada con exito </h1><hr />
                                                <p> Se ha editado el cine correctamente en la base de datos.</p>
                                                <a href='../panel_admin/index.php?state=mc'><button>Cerrar Mensaje</button></a>
                                            </div>
                                        </div>
                                        <div class='column side'></div>
                                    </div>
                                    ";
                //$result = './?state=mc'; 
            }
            else{
                $result[] = "El cine seleccionado no existe.";	                  
            }	
            $exist->free();	
		}
        return $result;	
	}

}

?>