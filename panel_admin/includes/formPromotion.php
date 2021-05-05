<?php

include_once('../assets/php/config.php');
include_once('../assets/php/common/promotion_dao.php');
include_once('../assets/php/common/promotion.php');
include_once('../assets/php/form.php');

class FormPromotion extends Form {

    //Atributes:
    private $correct;  // Indicates if the session is correct.
    private $reply; // Validation response
	private $option;

    //Constructor:
    public function __construct() {
        parent::__construct('formCinema');
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
											<p> Se ha añadido la promoción correctamente en la base de datos.</p>
											<a href='../panel_admin/index.php?state=mp'><button>Cerrar Mensaje</button></a>
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
															<p> Se ha editado la promoción correctamente en la base de datos.</p>
															<a href='../panel_admin/index.php?state=mp'><button>Cerrar Mensaje</button></a>
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
															<p> Se ha eliminado la promoción correctamente en la base de datos.</p>
															<a href='../panel_admin/index.php?state=mp'><button>Cerrar Mensaje</button></a>
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
										<a href='../panel_admin/index.php?state=mp'><button>Panel Admin</button></a>
									</div>
								<div class='column side'></div>
							</div>
							";
			
		}
        return $this->reply;
    }

    //Process form:
	public function processesForm($_id, $_tittle, $_description, $_code, $_active, $_option) {
		$this->correct = true;
		$this->option = $_option;

		$id= $this->test_input($_id);
		$tittle=$this->test_input($_tittle);
		$description=$this->test_input($_description);
		$code=$this->test_input($_code);
        $active=$this->test_input($_active);
	
		//Habria que validar todo para que encaje en la base de datos
			
		$bd = new Promotion_DAO('complucine');
		if($bd){
			if($this->option == "new"){
				 //Primero comprobar si los campos no son vacios y la duracion es mayor que 0
				if(!empty($tittle)&&!empty($description)&&!empty($code)&&!empty($active)){
					// comprobar si existe una pelicula con el mismo nombre y direccion
					$exist = $bd->GetPromotion($code);
					if( mysqli_num_rows($exist) != 0){
						$this->correct =false;
					}
					else{
						$bd->createPromotion(null, $tittle, $description, $code, $active);

					}
					$exist->free();
				}
				else{
					$this->correct =false;
				}	
			} else if ($this->option == "del"){
				//Primero comprobar si existe una pelicula con el mismo id
				$exist = $bd-> PromotionData($id);
				if( mysqli_num_rows($exist) == 1){
					$bd->deletePromotion($id);
				}
				else{
					$this->correct =false;
				}
			} else if ($this->option == "edit"){
				 //Primero comprobar si los campos no son vacios y la duracion es mayor que 0
                 if(!empty($tittle)&&!empty($description)&&!empty($code)&&!empty($active)){
					//comprobar si existe una pelicula con el mismo id
					$exist = $bd-> PromotionData($id);
					if( mysqli_num_rows($exist) == 1){
						$bd->editPromotion($id, $tittle, $description, $code, $active);
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