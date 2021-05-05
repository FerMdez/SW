<?php
	include_once('../assets/php/common/hall.php');
	include_once('./includes/formHall.php');	
		
    class Manager_panel {
        
		private $form;
        
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
			foreach(Hall::getListHalls("1") as $hall){ 
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
						</form>';
			return $panel;
        }
		
		static function new_hall(){		
			$panel = '<div class="column side"></div>
			   <div class="column middle">
					<h1>Crear una sala.</h1><hr /></br>
					'.
					FormHall::generaCampoFormulario(null, null, "new");
					'.
				</div>
			<div class="column side"></div>'."\n";
			
			return $panel;
		}
		
		static function edit_hall(){		
			$panel = '<div class="column side"></div>
			   <div class="column middle">
					<h1>Editar una sala.</h1><hr /></br>
				</div>
			<div class="column side"></div>'."\n";
			
			return $panel;
		}
			
		static function manage_sessions(){
            $name = strtoupper($_SESSION['nombre']);

            $panel = '<div class="code info">
                    <h1>Bienvenido '.$name.' a tu Panel de Manager.</h1>
                    <hr />
                    <p>Usuario: '.$name.'</p>
                    <p>Espero que estes pasando un buen dia</p>
                </div>'."\n";
				
			return $panel;
        }
    }
?>