<?php
	include_once('../assets/php/common/hall.php');
	include_once('../assets/php/common/session.php');
	include_once('./includes/formHall.php');	
	include_once('./includes/formSession.php');	
	
	
    class Manager_panel {
        
        function __construct($panel,$log){
            $this->state = $panel;
            $this->login = $log;

        }

		static function welcome(){
            $name = strtoupper($_SESSION['nombre']);

            $panel = '<div class="code info">
                    <h1>Bienvenido '.$name.' a tu Panel de Manager.</h1>
                    <hr />
                    <p>Usuario: '.$name.'</p>
                    <p>Espero que estes pasando un buen dia</p>
                </div>'."\n";
				
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
			$panel = '<form method="post" action="./?state=new_hall">
				<table class="alt">
					<thead>
						<tr>
							<th>Numero</th>
							<th>Filas</th>
							<th>Columnas</th>
						</tr>
					</thead>
					<tbody>'; 
			foreach(Hall::getListHalls($_SESSION["cinema"]) as $hall){ 
				$panel .='
						<tr>
							<td> '. $hall->getNumber().'</td>
							<td> '. $hall->getNumRows().'</td>
							<td> '. $hall->getNumCol().'</td>
							<td> <input type="submit" name="edit" value="Editar" class="button" formaction="./?state=edit_hall&number='.$hall->getNumber().'" ></td>
						</tr>';
				}
			$panel.='
					</tbody>
				</table>
				<input type="submit" name="new"  value="Añadir" class="button large" >
			</form>
';
			return $panel;
        }
		
		static function new_hall(){		
			$data = array("option" => "new_hall");
			$panel = '<div class="column side"></div>
				<div class="column middle">
					<h1>Crear una sala.</h1><hr /></br>
					'. FormHall::generaCampoFormulario($data, null).'
				</div>
			<div class="column side"></div>'."\n";
			
			return $panel;
		}
		
		static function edit_hall(){		
			$panel = '<div class="column side"></div>
			   <div class="column middle">
					<h1>Editar una sala.</h1><hr /></br>
					<p> En desarrollo... </p>
				</div>
			<div class="column side"></div>'."\n";
			
			return $panel;
		}
			
		static function manage_sessions(){
			//Base filtering values
			$date = isset($_POST['date']) ? $_POST['date'] : date("Y-m-d");
			$hall = isset($_POST['hall']) ? $_POST['hall'] : "1";
			
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
			$panel .='<div class = "column right">';
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
					$panel .='
							<tr>
								<td> '.date("H:i", strtotime( $session->getStartTime())).' </td>
								<td> '. str_replace('_', ' ', Session::getFilmTitle($session->getIdfilm())) .' </td>
								<td> '.$session->getFormat().' </td>
								<td> '.$session->getSeatPrice().' </td>
								<td> <input type="date" name="date" value="'.$date.'">
								<form method="post" action="./?state=edit_session">
									<input  name="film" type="hidden" value="'.$session->getIdfilm().'">
									<input  name="hall" type="hidden" value="'.$session->getIdhall().'">
									<input  name="date" type="hidden" value="'.$session->getDate().'">
									<input  name="start" type="hidden" value="'.$session->getStartTime().'">
									<input  name="price" type="hidden" value="'.$session->getSeatPrice().'">
									<input  name="format" type="hidden" value="'.$session->getFormat().'">	
								<td> <input type="submit" name="edit" value="Editar" class="button" ></td>
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
				<input type="submit" name="submit" form="filter"  value="Añadir" class="button large" formaction="./?state=new_session">
			</div>
';
			
			return $panel;
        }
		
		static function new_session(){		
			$data = array("option" => "new_session","hall" => $_POST['hall'],"cinema" => $_SESSION["cinema"],"date" => $_POST['date']);
			
			$panel = '<h1>Crear una sesión.</h1><hr /></br>
			'.FormSession::generaCampoFormulario($data, null);
			
			return $panel;
		}
		
		static function edit_session(){		
			$data = array("option" => "edit_session","hall" => $_POST["hall"],"cinema" => $_SESSION["cinema"],"date" => $_POST['date'],"film" => $_POST['film'],"start" => $_POST['start'],"price" => $_POST['price'],"format" => $_POST['format']);
			$panel = '<h1>Editar una sesión.</h1><hr /></br>
			'.FormSession::generaCampoFormulario($data, null);
			
			return $panel;
		}
    }
?>