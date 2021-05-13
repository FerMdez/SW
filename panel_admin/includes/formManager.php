<?php

include_once('../assets/php/config.php');
include_once('../assets/php/common/manager_dao.php');
include_once('../assets/php/common/manager.php');
include_once('../assets/php/form.php');

class FormManager extends Form {

    //Atributes:
    private $correct;  // Indicates if the session is correct.
    private $reply; // Validation response
	private $option;

    //Constructor:
    public function __construct() {
        parent::__construct('formManager');
        $this->reply = array();
    }

    public function getReply() {
		if($this->correct){
			if($this->option == "new"){
				$this->reply = "<div class='row'>
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
			}else if($this->option == "edit"){
								$this->reply = "<div class='row'>
													<div class='column side'></div>
													<div class='column middle'>
														<div class='code info'>
															<h1> Operacion realizada con exito </h1><hr />
															<p> Se ha editado el gerente correctamente en la base de datos.</p>
															<a href='../panel_admin/index.php?state=mg'><button>Cerrar Mensaje</button></a>
														</div>
													<div class='column side'></div>
												</div>
												";
			}else if($this->option == "del"){
								$this->reply = "<div class='row'>
													<div class='column side'></div>
													<div class='column middle'>
														<div class='code info'>
															<h1> Operacion realizada con exito </h1><hr />
															<p> Se ha eliminado el gerente correctamente en la base de datos.</p>
															<a href='../panel_admin/index.php?state=mg'><button>Cerrar Mensaje</button></a>
														</div>
													<div class='column side'></div>
												</div>
												";
			}

		} else {
			$this->reply = "<div class='row'>
								<div class='column side'></div>
								<div class='column middle'>
									<div class='code info'>
										<h1> ERROR  </h1><hr />
										<p> Ha habido un error en la operacion. Revisa los datos introducidos</p>
										<a href='../panel_admin/index.php?state=mg'><button>Panel Admin</button></a>
									</div>
								<div class='column side'></div>
							</div>
							";
			
		}
        return $this->reply;
    }

    //Process form:
	public function processesForm($_id, $_idcinema, $_option) {
		$this->correct = true;
		$this->option = $_option;

		$id= $this->test_input($_id);
		$idcinema=$this->test_input($_idcinema);
		
	
		//Habria que validar todo para que encaje en la base de datos
			
		$bd = new Manager_DAO('complucine');
		if($bd){
			if($this->option == "new"){
				//Check if any var is empty
				if(!is_null($id)&&!is_null($idcinema)){
					// check if already exist a manager with same name
					$exist = $bd->GetManagerCinema($id, $idcinema);
					if( mysqli_num_rows($exist) != 0){
						$this->correct =false;
					}
					else{
						$bd->createManager($id, $idcinema);

					}
					$exist->free();
				}
				else{
					$this->correct =false;
				}	
			} else if ($this->option == "del"){
				//Check if exist a manager with this id
				$exist = $bd-> GetManager($id);
				if( mysqli_num_rows($exist) == 1){
					$bd->deleteManager($id);
				}
				else{
					$this->correct =false;
				}
			} else if ($this->option == "edit"){
				 //Check if any var is  empty
                 if(!empty($idcinema)){
					//Check if exist a manager with this id
					$exist = $bd-> GetManager($id);
					if( mysqli_num_rows($exist) == 1){
						$bd->editManager($id,$idcinema);
					}
					else{
						$this->correct =false;
					}
					$exist->free();
				}
				else{
					$this->correct =false;
				}
			} 
			else {$this->correct = false;}			
		}
		
	
	}

	protected function test_input($input){
		return htmlspecialchars(trim(strip_tags($input)));
	}
}


?>