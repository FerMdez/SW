<?php
	include_once($prefix.'assets/php/includes/hall.php');
	include_once($prefix.'assets/php/includes/session.php');
	require_once($prefix.'assets/php/includes/manager.php');
	require_once($prefix.'assets/php/includes/cinema_dao.php');
	include_once('./includes/formHall.php');	
	include_once('./includes/formSession.php');	

	
    class Manager_panel {
		
        function __construct(){}

		static function welcome($manager){
			$bd = new Cinema_DAO('complucine');
			if($bd){
				$cinema = ($bd->cinemaData( $manager->getIdcinema() ) );
				$c_name = $cinema->getId();
				$c_dir = $cinema->getId();
				$c_tel = $cinema->getId();
			}
            $name = strtoupper($_SESSION["nombre"]);
			$cinema = strtoupper( $manager->getIdcinema());

            $panel = '<div class="code info">
						<h1>Bienvenido '.$name.' a tu Panel de Manager.</h1>
						<hr />
						<p>Usuario: '.$name.'</p> <br>
						<p>Cine: '.$c_name.'</p>
						<p>Dirección: '.$c_dir.'</p>
						<p>Telefono: '.$c_tel.'</p> <br>
						<p>Espero que estes pasando un buen dia</p>
					</div>';
				
			return $panel;
        }
		
		static function welcomeAdmin($manager) {
			$cinemaList = new Cinema_DAO('complucine');
			$cinemas = $cinemaList->allCinemaData();	
			$cinema = 1;

            $name = strtoupper($_SESSION["nombre"]);
			if(isset($_POST['change'])){
				$manager->setIdcinema($_POST['cinema']);
			}

			if($manager->getIdcinema() != null) $cinema = strtoupper( $manager->getIdcinema());

            $panel = '<div class="code info">
						<h1>Bienvenido '.$name.' a tu Panel de Manager.</h1>
						<hr />
						<p>Usuario: '.$name.'</p>
						<p>Cine: '.$cinema.'</p>
						<p>Espero que estes pasando un buen dia</p>
						<form method="post" id="changecinema" action="index.php">
							<select name="cinema" class="button">
							';
					foreach($cinemas as $c){ 
						if($c->getId() == $cinema){
							$panel .=  "<option value=\"". $c->getId() ." \"selected> " . $c->getId() ."</option>
							";
						}else{
							$panel .=  "<option value=\"". $c->getId() ." \"> " . $c->getId() . "</option>
							";
					}
				}
		$panel .= '				<input type="submit" name="change" value="Cambiar" /><br>
							</select>
						</form>
					</div>';

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
		
		static function manage_halls($manager){	
			
			$panel = '<div class="column side"></div>
					<div class="column middle">';
			$listhall = Hall::getListHalls($manager->getIdcinema());
			if(!$listhall){
				$panel .= "<h2> No hay ninguna sala en este cine";
			}else{
			$panel .= '
			<div class="tablelist">
				<u1">
					<li class="title"> Salas </li>
					<li class="title"> Asientos </li>
					<li class="title"> Sesiones </li> <br>
							'; 
			$parity = "odd";
			foreach($listhall as $hall){ 
				$panel .='<div class='.$parity.'>
							<a href="?state=edit_hall&number='. $hall->getNumber().'">
								<li> '. $hall->getNumber().'</li>
								<li> '.$hall->getTotalSeats().' </li>
							</a>
							<a href="?state=manage_sessions&hall='. $hall->getNumber().'">
								<li> Sessiones</li>
							</a>
						</div>
						';
				$parity = ($parity == "odd") ? "even" : "odd";
				}
			$panel.='
						</ul>
					</div>';
			}
			$panel.='
						<form method="post" action="./?state=new_hall">
							<input type="submit" name="new_hall" value="Añadir Sala" class="button large" />
						</form>
				</div>
				<div class="column side"></div>';			
			return $panel;
        }
		
		static function new_hall($manager){		
		
			$formHall = new FormHall("new_hall",$manager->getIdcinema(),new Hall(null, null, null, null, null, null));
		
			$panel = '<h1>Crear una sala.</h1><hr/></br>
				'.$formHall->gestiona();
			return $panel;
		}
		
		static function edit_hall($manager){	
			$hall = Hall::search_hall($_GET["number"], $manager->getIdcinema());
			
			if($hall || isset($_POST["restart"]) || isset($_POST["filter"]) || isset($_POST["sumbit"]) ){
				
				$formHall = new FormHall("edit_hall",$manager->getIdcinema(), $hall);
				$panel = '<h1>Editar una sala.</h1><hr/></br>
					'.$formHall->gestiona();
				return $panel;
			} else{
				return Manager_panel::warning($manager);
			}
		}
		
		static function manage_sessions($manager){
			//Base filtering values
			$date = $_POST['date'] ?? $_GET['date'] ?? date("Y-m-d");
			$hall = $_POST['hall'] ?? $_GET['hall'] ?? "1";
			
			//Session filter
			$panel='<div class = "column left">
					<form method="post" id="filter" action="./?state=manage_sessions">
						<input type="date" name="date" value="'.$date.'" min="2021-01-01" max="2031-12-31">
							<select name="hall" class="button large">';
						
			foreach(Hall::getListHalls($manager->getIdcinema()) as $hll){
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
			$sessions = Session::getListSessions($hall,$manager->getIdcinema(),$date);
			
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
		
		static function new_session($manager){	
			$formSession = new FormSession("new_session", $manager->getIdcinema() );
			
			$panel = '<h1>Crear una sesion.</h1> <hr/> </br>
				'.$formSession->gestiona();
			return $panel;
		}
		
		static function edit_session($manager){	
			$formSession = new FormSession("edit_session", $manager->getIdcinema() );
		
			$panel = '<h1>Editar una sesion.</h1><hr/></br>
				'.$formSession->gestiona();
			return $panel;
		}
		
		//TODO: estado al modificar sesiones para la seleccion de peliculas usando el template->print films
		static function select_film($template,$manager){		
			if(isset($_POST["select_film"]) && isset($_POST["option"])){
				$_SESSION["option"] = $_POST["option"];
				$panel = '<h1>Seleccionar Pelicula.</h1><hr /></br>';
				$panel .= $template->print_fimls();
				$_SESSION["option"] = "";
			} else $panel = self::warning($manager);
			
			return $panel;
		}
		
		//Funcion que se envia cuando hay inconsistencia en el panel manager, principalmente por tocar cosas con la ulr
		static function warning($manager){
			$panel = '<div class="code info">
                    <h1>Ha habido un error.</h1>
                    <hr />
                    <p> >.< </p>
                </div>'."\n";
				
			return $panel;
		}
		
	
    }
?>