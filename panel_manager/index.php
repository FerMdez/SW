<?php

    //General Config File:
    require_once('../assets/php/config.php');
    //Controller file:
    require_once('panel_manager.php');
	require_once('../assets/php/common/manager_dao.php');
	require_once('../assets/php/common/manager.php');
	require_once('../assets/php/common/user.php');
	
    if($_SESSION["login"] && $_SESSION["rol"] === "manager"){
		$bd = new Manager_DAO('complucine');
		$manager = false;
		if($bd && !$manager){
			$user = unserialize($_SESSION["user"]);
			$manager = $bd->GetManager($user->getId());
			
			if($manager){
				if($manager->num_rows == 1){
					$fila = $manager->fetch_assoc();
					$manager = new Manager($fila["id"], $fila["idcinema"], null, null, null);
				}
			}
		}
		$state = isset($_GET['state']) ? $_GET['state'] : '';
		switch($state){
			case "view_ruser":
			case "view_user":
				   $panel = '<div class="column side"></div>
				   <div class="column middle">
						<div class="code info">
							<h1>Esta vista aun no esta implementada.</h1><hr />
						</div>
					</div>
				<div class="column side"></div>'."\n";
				break;			
			case "manage_halls":
				$panel = Manager_panel::manage_halls($manager);
				break;
			case "new_hall":
				$panel = Manager_panel::new_hall($manager);
				break;	
			case "edit_hall":
				$panel = Manager_panel::edit_hall($manager);
				break;	
			case "manage_sessions":
				$panel = Manager_panel::manage_sessions($manager);
				break;
			case "new_session":
				$panel = Manager_panel::new_session($manager);
				break;
			case "edit_session":
				$panel = Manager_panel::edit_session($manager);
				break;
			case "select_film":
				$panel = Manager_panel::select_film($template,$manager);
				break;
			case "success":
				$panel = Manager_panel::success();
				break;
			default:  
				$panel = Manager_panel::welcome($manager);
				break;
		}
    }
    else{
        $panel = '<div class="column side"></div>
                   <div class="column middle">
						<div class="code info">
                            <h1>Debes iniciar sesión para ver el Panel de Manager.</h1><hr />
                            <p>Inicia Sesión en una cuenta con permisos.</p>
                            <a href="'.$prefix.'login/" ><button class="button large">Iniciar Sesión</button></a>
						</div>
					</div>
                <div class="column side"></div>'."\n";
    }

    //Specific page content:
        $section = '<!-- Manager Panel -->
		<link rel="stylesheet" href="../assets/css/manager.css">
        <section id="manager_panel">
			<!-- Contents -->
			<div class="row">
				'.$panel.'
			</div>
        </section>';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>
