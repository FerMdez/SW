<?php
	include_once($prefix.'assets/php/includes/hall.php');
	include_once($prefix.'assets/php/includes/session.php');
	require_once($prefix.'assets/php/includes/manager.php');
	require_once($prefix.'assets/php/includes/cinema_dao.php');
	include_once('./includes/formHall.php');	
	include_once('./includes/formSession.php');	

	
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
			<a href="?state=calendar"> <p> Hack para entrar al calendario <p> </a>
            </div>'."\n"; 
			
			return $panel;
        }
		
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
					<img src='.$userPic.' alt="user_profile_picture"/>
					<h3>'.strftime("%A %e de %B de %Y | %H:%M").'</h3>
					<p>Usuario: '.$name.'</p>  <br>
					<h3>Como administrador puedes escoger el cine que gestionar</h3>
					<p>Cine: '.$c_name.'</p>
					
					<a href="?state=calendar"> <p> Hack para entrar al calendario <p> </a>
             
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
		$panel .= '				<input type="submit" name="changecinema" value="Cambiar" /><br>
							</select>
						</form>
					</div>';

			return $panel;
		}
		static function calendar(){
			
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
									<option data-feed="./eventos.php?hall='.$hll->getNumber().'" value="'. $hll->getNumber() .'"selected> Sala '. $hll->getNumber() .'</option> ';
					}else{ 
						$panel.= '
									<option data-feed="./eventos.php?hall='.$hll->getNumber().'" value="'. $hll->getNumber() .'"> Sala '. $hll->getNumber() .'</option>';
					}
				}
				$panel.='
						</select>
					</div>		
					<div class="column side"></div>	
				</div>
					<div class="row">
						<div id="calendar"></div>
					</div>';
			}else{
				$panel ='<div class="row">
							<h3> No hay ninguna sala en este cine </h3>
							<a href=."/?state=new_hall"> Añadir Sala </a>
						</div>';
			}

			
			return $panel;
		}
		static function success(){
            $panel = '<div class="code info">
                    <h1>Operacion completada.</h1>
                    <hr />
                    <p>'.$_SESSION['msg'].'</p>
                </div>'."\n";
			$_SESSION['msg'] = "";
			
			return $panel;
        }
		
		static function manage_halls(){	
			
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
							<a href="?state=calendar&hall='. $hall->getNumber().'">
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
		
		static function manage_sessions(){
			//Base filtering values
			$date = $_POST['date'] ?? $_GET['date'] ?? date("Y-m-d");
			$hall = $_POST['hall'] ?? $_GET['hall'] ?? "1";
			
			//Session filter
			$panel='<div class = "column left">
					<form method="post" id="filter" action="./?state=manage_sessions">
						<input type="date" name="date" value="'.$date.'" min="2021-01-01" max="2031-12-31">
							<select name="hall" class="button large">';
						
			foreach(Hall::getListHalls($_SESSION["cinema"]) as $hll){
				if($hll->getNumber() == $hall){
					$panel.= '
								<option value="'. $hll->getNumber() .'"selected> Sala '. $hll->getNumber() .'</option> ';
				}else{ 
					$panel.= '
								<option value="'. $hll->getNumber() .'"> Sala '. $hll->getNumber() .'</option>';
				}
			}
			$panel.='
							</select>
						<input type="submit" name="filter" value="Filtrar" class="button large"/>
					</form>
				</div>
			';
			//Session list
			$panel .='	<div class = "column right">';
			$sessions = Session::getListSessions($hall,$_SESSION["cinema"],$date);
			
			if($sessions) {
				$panel .='
					<form method="post" action="./?state=edit_session">
						<table class="alt">
							<thead>
								<tr>
									<th>Hora</th>
									<th>Pelicula</th>
									<th>Formato</th>
									<th>Precio</th>
								</tr>
							</thead>
							<tbody>'; 
				
				
				foreach($sessions as $session){ 
					$film = Session::getThisSessionFilm($session->getIdfilm());
					$panel .='
								<tr>
									<td> '.date("H:i", strtotime( $session->getStartTime())).' </td>
									<td> '. str_replace('_', ' ', $film["tittle"]) .' </td>
									<td> '.$session->getFormat().' </td>
									<td> '.$session->getSeatPrice().' </td>
									<form method="post" action="./?state=edit_session">
										<input  name="film" type="hidden" value="'.$session->getIdfilm().'">
										<input  name="tittle" type="hidden" value="'.$film["tittle"].'">
										<input  name="duration" type="hidden" value="'.$film["duration"].'">
										<input  name="language" type="hidden" value="'.$film["language"].'">
										<input  name="description" type="hidden" value="'.$film["description"].'">
										<input  name="hall" type="hidden" value="'.$session->getIdhall().'">
										<input  name="date" type="hidden" value="'.$session->getDate().'">
										<input  name="start" type="hidden" value="'.$session->getStartTime().'">
										<input  name="price" type="hidden" value="'.$session->getSeatPrice().'">
										<input  name="format" type="hidden" value="'.$session->getFormat().'">	
									<td> <input type="submit" id="submit" name ="edit_session"  value="Editar" class="primary" /> </td>
									</form>
								</tr>';
					}
				$panel.='
							</tbody>
						</table>
					</form>';
			} else {
				$panel.=' <h3> No hay ninguna sesion </h3>';
			}
			$panel.='
					<input type="submit" name="new_session" form="filter"  value="Añadir" class="button large" formaction="./?state=new_session">
				</div>';
			
			return $panel;
        }
		
		static function new_session(){	
			$formSession = new FormSession("new_session", $_SESSION["cinema"] );
			
			$panel = '<h1>Crear una sesion.</h1> <hr/> </br>
				'.$formSession->gestiona();
			return $panel;
		}
		
		static function edit_session(){	
			$formSession = new FormSession("edit_session", $_SESSION["cinema"] );
		
			$panel = '<h1>Editar una sesion.</h1><hr/></br>
				'.$formSession->gestiona();
			return $panel;
		}
		
		//TODO: estado al modificar sesiones para la seleccion de peliculas usando el template->print films
		static function select_film($template){		
			if(isset($_POST["select_film"]) && isset($_POST["option"])){
				$_SESSION["option"] = $_POST["option"];
				$panel = '<h1>Seleccionar Pelicula.</h1><hr /></br>';
				$panel .= $template->print_fimls();
				$_SESSION["option"] = "";
			} else $panel = self::warning();
			
			return $panel;
		}
		
		//Funcion que se envia cuando hay inconsistencia en el panel manager, principalmente por tocar cosas con la ulr
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
