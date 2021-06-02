<?php
//General Config File:
include_once('../assets/php/config.php');
include_once('../assets/php/includes/manager_dao.php');
include_once('../assets/php/includes/manager.php');
include_once('../assets/php/includes/cinema_dao.php');
include_once('../assets/php/includes/user_dao.php');
include_once('../assets/php/form.php');

class formAddManager extends Form{
	//Constants:
	const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$'; 

	public function __construct() {
        $options = array("action" => "./?state=mg");
        parent::__construct('formAddManager', $options);
    }

	protected function generaCamposFormulario($datos, $errores = array()){
       

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorId = self::createMensajeError($errores, 'id', 'span', array('class' => 'error'));
        $errorIdCinema = self::createMensajeError($errores, 'idcinema', 'span', array('class' => 'error'));

		$html = '<fieldset id="film_form"><pre>'.$htmlErroresGlobales.'</pre>
                    <legend>Selecciona usuario.</legend><pre>'.$errorId.'</pre>' 
                    .$this->showUsers().
                    '</fieldset>
                    <fieldset>
                    <legend>Selecciona cine.</legend><pre>'.$errorIdCinema.'</pre>'
                    .$this->showCinemas().
                    '</fieldset>
                <div class="actions"> 
                        <input type="submit" id="submit" value="Seleccionar" name="add_manager" class="primary" />
                        <input type="reset" id="reset" value="Borrar" />       
                        </div>
                </div>
                ';

        return $html;
    }

	protected function procesaFormulario($datos){
        $result = array();
        
        $id = $this->test_input($datos['id']) ?? null;
        if (is_null($id) ) {
            $result['id'] = "ERROR. No existe un usuario con ese ID";
        }

        $idcinema = $this->test_input($datos['idcinema']) ?? null;
		//||!mb_ereg_match(self::HTML5_EMAIL_REGEXP, $duration) 
        if (empty($idcinema)) {
            $result['idcinema'] = "ERROR. No existe un cine con ese ID";
        }
        
        
        if (count($result) === 0) {
        	$bd = new Manager_DAO("complucine");

            // check if already exist a manager with same name
            $exist = $bd->GetManagerCinema($id, $idcinema);
            if( mysqli_num_rows($exist) != 0){
                $result[] = "Ya existe un manager asociado a este usuario y cine";
            }
            else{
                $bd->createManager($id, $idcinema);
                $_SESSION['message'] = "<div class='row'>
                                        <div class='column side'></div>
                                        <div class='column middle'>
                                            <div class='code info'>
                                                <h1> Operacion realizada con exito </h1><hr />
                                                <p> Se ha añadido el gerente correctamente en la base de datos.</p>
                                                <a href='../panel_admin/index.php?state=mg'><button>Cerrar Mensaje</button></a>
                                            </div>
                                        <div class='column side'></div>
                                    </div>
                    ";
                $result = './?state=mg';
            }
            $exist->free();
            
            	
		}
		return $result;
	}

    private function showUsers() {
        $user = new UserDAO("complucine");
        $users = $user->allUsersNotM();
        $ids = array();
        $usernames = array();
        $emails = array();
        $roles = array();
        

        foreach($users as $key => $value){
            $ids[$key] = $value->getId();
            $usernames[$key] = $value->getName();
            $emails[$key] = $value->getEmail();
            $roles[$key] = $value->getRol();
        }
        $html='';
        for($i = 0; $i < count($users); $i++){
            $html .= '
            <input type="radio" class="content-input" name="id" value="'.$ids[$i].'" id="'.$ids[$i].'"><label class="efe" for="'.$ids[$i].'"> '.$ids[$i].', '.$usernames[$i].
            ', '.$usernames[$key].
            '
            </label>
            ';
        }
        return $html;
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
            <input type="radio" class="content-input" name="idcinema" value="'.$ids[$i].'" id="'.$ids[$i].'"><label class="efe" for="'.$ids[$i].'">  '.$ids[$i].', '.$names[$i].'
            </label>
            ';
        }
        return $html;
    }


}

?>