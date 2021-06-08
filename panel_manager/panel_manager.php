<?php
	include_once($prefix.'assets/php/includes/hall.php');
	include_once($prefix.'assets/php/includes/session.php');
	require_once($prefix.'assets/php/includes/cinema_dao.php');
	include_once('./includes/formHall.php');	
	include_once('./includes/SessionForm.php');
	
    class Manager_panel {
        function __construct(){}
		
		static function welcome(){
			$bd = new Cinema_DAO('complucine');
			if($bd){
				
				$cinema = $bd->cinemaData($_SESSION["cinema"]);
				$c_name = $cinema->getName();
				$c_dir = $cinema->getDirection();
			}
            $name = strtoupper($_SESSION["nombre"]);
			$userPic = USER_PICS.strtolower($name).".jpg";

			$panel=  '<div class="code welcome">
					<h1>Bienvenido '.$name.' a tu Panel de Manager.</h1>
            <hr />
            <img src='.$userPic.' alt="user_profile_picture"/>
            <h3>'.strftime("%A %e de %B de %Y | %H:%M").'</h3>
			<p>Usuario: '.$name.'</p>  <br>
			<p>Cine: '.$c_name.'</p>
			<p>Dirección: '.$c_dir.'</p>
            </div>'."\n"; 
			
			return $panel;
        }
		
		// Admin welcome panel allows to change the cinema linked to the admin-like-manager
		static function welcomeAdmin() {
			$cinemaList = new Cinema_DAO('complucine');
			$cinemas = $cinemaList->allCinemaData();	
			
			$bd = new Cinema_DAO('complucine');
			
			$c_name = "Aun no se ha escogido un cine";
			
			if($bd && $_SESSION["cinema"] ){
				
				$cinema = $bd->cinemaData($_SESSION["cinema"]);
				$c_name = $cinema->getName();
				$cinema = $cinema->getId();
			}

            $name = strtoupper($_SESSION["nombre"]);
			$userPic = USER_PICS.strtolower($name).".jpg";

			$panel=  '<div class="code welcome">
					<h1>Bienvenido '.$name.' a tu Panel de Manager.</h1>
					<hr />
					<div class="column side"> </div>
					<div class="column middle">
					<img src='.$userPic.' alt="user_profile_picture"/>
					<h3>'.strftime("%A %e de %B de %Y | %H:%M").'</h3>
					<p>Usuario: '.$name.'</p>  <br>
					<h3>Como administrador puedes escoger el cine que gestionar</h3>
					<p>Cine: '.$c_name.'</p>
             
						<form method="post" id="changecinema" action="index.php">
							<select name="cinema" class="button large">
							';
					foreach($cinemas as $c){ 
						if($c->getId() == $cinema){
							$panel .=  "<option value=\"". $c->getId() ." \"selected> " . $c->getName() ."</option>
							";
						}else{
							$panel .=  "<option value=\"". $c->getId() ." \"> " . $c->getName() . "</option>
							";
					}
				}
		$panel .= '			<input type="submit" id="submit" name="changecinema" value="Cambiar" class="primary" />
							</select>
						</form>
					</div>
					<div class="column side"> </div>
					';

			return $panel;
		}
		//Manage the sessions using full calendar js events and a pop up form which is constantly edited with more js
		static function calendar(){
			if(isset($_SESSION["cinema"])){
				$hall = $_POST['hall'] ?? $_GET['hall'] ?? "1";
				$halls = Hall::getListHalls($_SESSION["cinema"]);
				
				if($halls){
					$panel ='
					<div class="row">
						<div class="column side"></div>
						<div class="column middle">
							<br>
							<select id="hall_selector" class="button large">';
					foreach(Hall::getListHalls($_SESSION["cinema"]) as $hll){
						if($hll->getNumber() == $hall){
							$panel.= '
										<option data-feed="./eventsProcess.php?hall='.$hll->getNumber().'" value="'. $hll->getNumber() .'"selected> Sala '. $hll->getNumber() .'</option> ';
						}else{ 
							$panel.= '
										<option data-feed="./eventsProcess.php?hall='.$hll->getNumber().'" value="'. $hll->getNumber() .'"> Sala '. $hll->getNumber() .'</option>';
						}
					}
					$panel.='
							</select>
						</div>		
						<div class="column side"></div>	
					</div>
						<div class="row fc-container">
							<div id="calendar"></div>
								<div id="myModal" class="modal">

								<div class="modal-content">
								<span class="close">&times;</span> <br> <br>
									'.SessionForm::getForm().'
								</div>
							</div>
							</div>';
				}else{
					$panel ='<div class="row">
								<h3> No hay ninguna sala en este cine </h3>
								<a href=."/?state=new_hall"> Añadir Sala </a>
							</div>';
				}
			}else{
				$panel = '<div class="code info">
				<h1>Aun no se ha seleccionado un cine.</h1>
				<hr />
				<p> >.< </p>
				<p> Selecciona un cine en el panel principal </p>
				</div>'."\n";
			}
				return $panel;

		}
		
		static function success(){
			$msg = "operacion completada con exito";
			if(isset($_GET["new"])) $msg = "La sala se ha creado con exito";
			if(isset($_GET["edit"])) $msg = "La sala se ha editado con exito";
			if(isset($_GET["del"])) $msg = "La sala se ha eliminado con exito";
			
            $panel = '<div class="code info">
                    <h1>Operacion completada.</h1>
                    <hr />
                    <p>'.$msg.'</p>
                </div>'."\n";
			
			return $panel;
        }
		
		static function manage_halls(){	
			if(isset($_SESSION["cinema"])){
				$panel = '<div class="column side"></div>
						<div class="column middle">';
				$listhall = Hall::getListHalls($_SESSION["cinema"]);
				if(!$listhall){
					$panel .= "<h2> No hay ninguna sala en este cine";
				}else{
				$panel .= '
					<ul class="tablelist col3">
						<li class="title"> Sala </li>
						<li class="title"> Asientos </li>
						<li class="title"> Sesión </li>
								'; 
				$parity = "odd";
				foreach($listhall as $hall){ 
					$panel .='<div class="'.$parity.'">
								<a class="h2long" href="?state=edit_hall&number='. $hall->getNumber().'">
									<li> '. $hall->getNumber().'</li>
									<li> '.$hall->getTotalSeats().' </li>
								</a>
								<a href="?state=manage_sessions&hall='. $hall->getNumber().'">
									<li> Sesiones </li>
								</a>
							</div>
							';
					$parity = ($parity == "odd") ? "even" : "odd";
					}
				$panel.='
					</ul>';
				}
				$panel.='
							<form method="post" action="./?state=new_hall">
								<input type="submit" name="new_hall" value="Añadir Sala" class="button large" />
							</form>
					</div>
					<div class="column side"></div>';			
			}else{
				$panel = '<div class="code info">
				<h1>Aun no se ha seleccionado un cine.</h1>
				<hr />
				<p> >.< </p>
				<p> Selecciona un cine en el panel principal </p>
				</div>'."\n";
			}
			return $panel;
        }
		
		static function new_hall(){		
		
			$formHall = new FormHall("new_hall",$_SESSION["cinema"],new Hall(null, null, null, null, null, null));
		
			$panel = '<h1>Crear una sala.</h1><hr/></br>
				'.$formHall->gestiona();
			return $panel;
		}
		
		static function edit_hall(){	
			$hall = Hall::search_hall($_GET["number"], $_SESSION["cinema"]);
			
			if($hall || isset($_POST["restart"]) || isset($_POST["filter"]) || isset($_POST["sumbit"]) ){
				
				$formHall = new FormHall("edit_hall",$_SESSION["cinema"], $hall);
				$panel = '<h1>Editar una sala.</h1><hr/></br>
					'.$formHall->gestiona();
				return $panel;
			} else{
				return Manager_panel::warning();
			}
		}
		
		//this function is used as an answer to wrong url parameters accesing a formhall edit. The formsession version has been replaced by other js error replys
		static function warning(){
			$panel = '<div class="code info">
                    <h1>Ha habido un error.</h1>
                    <hr />
                    <p> >.< </p>
                </div>'."\n";
				
			return $panel;
		}
    }
?>
