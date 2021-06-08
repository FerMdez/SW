<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/includes/cinema_dao.php');
include_once('../assets/php/includes/cinema.php');
include_once('../assets/php/form.php');

class formAddCinema extends Form{

    public function __construct(){
        $op = array("action"=>"./?state=mc");
        parent::__construct('formAddCinema',$op);
    } 

    protected function generaCamposFormulario($datos,$errores=array()){

        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorName = self::createMensajeError($errores,'namecinema','span',array('class'=>'error'));
        $errorDirection = self::createMensajeError($errores,'direction','span',array('class'=>'error'));
        $errrorPhone = self ::createMensajeError($errores,'phone',array('class'=>'error'));

        $html = '<div class="row"></div>
                    <fieldset id = "cinema_form">'.$htmlErroresGlobales.'</pre>
                    <legend>Añadir cine</legend>
                     <input type="text" name="namecinema" id="namecinema" placeholder="Nombre" required/><pre>'.$errorName.'</pre>
                     <input type="text" name="direction" id="direction" placeholder="Direccion" required/><pre>'.$errorDirection.'</pre> 
                     <input type="text" name="phone" id="phone" placeholder="Teléfono" required/><pre>'.$errrorPhone.'</pre>
                    </fieldset>
                    <div class="actions"> 
                        <input type="submit" id="submit" value="Añadir cine" class="primary" />
                        <input type="reset" id="reset" value="Borrar" />       
                    </div>
                </div>  ';
        return $html;
    }           
    
     //Process form:
	public function procesaFormulario($datos) {
        $result =array();
        
        $name = $this->test_input($datos['namecinema'])??null;

        if(empty($name)){
            $result['namecinema']= "El nombre no es válido";
        }
        
        $direction = $this -> test_input($datos['direction']) ?? null;

        if(empty($direction)){
            $result['direction'] = "La dirección no es valida";
        }

        $phone = $this -> test_input($datos['phone']) ?? null;

        if(empty($phone)){
            $result['phone'] = "El teléfono no es valido";
        }
	
        if(count($result)===0){
        
		$bd = new Cinema_DAO('complucine');
        $exist = $bd -> GetCinema($name,$direction);
		    if(mysqli_num_rows($exist)!=0){
                $result[] = "Ya existe un cine con ese nombre o dirección";
            }
            else{
                $bd->createCinema(null,$name,$direction,$phone);
                $_SESSION['message'] = "<div class='row'>
                                        <div class='column side'></div>
                                        <div class='column middle'>
                                            <div class='code info'>
                                                <h1> Operacion realizada con exito </h1><hr />
                                                <p> Se ha añadido el cine correctamente en la base de datos.</p>
                                                <a href='../panel_admin/index.php?state=mc'><button>Cerrar Mensaje</button></a>
                                            </div>
                                        </div>
                                        <div class='column side'></div>
                                    </div>
                                    ";
                //$result = './?state=mc';                    
            }	
            $exist->free();	
		}
        return $result;	
	}

}

?>