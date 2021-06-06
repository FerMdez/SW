<?php
    //General Config File:
    require_once('../assets/php/config.php');
    //Controller file:
    require_once('panel_manager.php');
	require_once('../assets/php/includes/manager_dao.php');
	require_once('../assets/php/includes/manager.php');
	require_once('../assets/php/includes/user.php');

	if($_SESSION["login"] && isset($_SESSION["lastRol"]) && ($_SESSION["lastRol"] === "admin" || $_SESSION["rol"] === "manager")) {
		$manager = new Manager(null, null, null, null, null);
		if(isset($_POST['changecinema']))$_SESSION['cinema'] = $_POST['cinema'];
		

		$state = isset($_GET['state']) ? $_GET['state'] : '';
		switch($state){
			case "view_user":
				$_SESSION["rol"] = null;
				
				$panel .= "<div class='row'>
							<div class='column side'></div>
							<div class='column middle'>
								<div class='code info'>
									<h1> ¡ATENCIÓN! </h1><hr />
									<p>Está viendo la web como un Usuario NO Registrado.</p>
									<a href='".$prefix."'><button>Cerrar Mensaje</button></a>
								</div>
							</div>
							<div class='column side'></div>
						</div>
						";
				break;
			case "view_ruser":
				$_SESSION["rol"] = "user";
				unset($_SESSION["cinema"]);
				$panel .= "<div class='row'>
							<div class='column side'></div>
							<div class='column middle'>
								<div class='code info'>
									<h1> ¡ATENCIÓN! </h1><hr />
									<p>Está viendo la web como un Usuario Registrado.</p>
									<a href='".$prefix."'><button>Cerrar Mensaje</button></a>
								</div>
							</div>
							<div class='column side'></div>
						</div>
						";
				break;			
			case "manage_halls":
				$panel = Manager_panel::manage_halls();
				break;
			case "new_hall":
				$panel = Manager_panel::new_hall();
				break;	
			case "edit_hall":
				$panel = Manager_panel::edit_hall();
				break;	
			case "manage_sessions":
				$panel = Manager_panel::calendar();
				break;
			case "success":
				$panel = Manager_panel::success();
				break;
			default:  
				$panel = Manager_panel::welcomeAdmin($manager);
				break;
		}
	}
    else if($_SESSION["login"] && $_SESSION["rol"] === "manager"){
		
		if(!isset($_SESSION['cinema'])){
			$bd = new Manager_DAO('complucine');
			if($bd){
				$user = unserialize($_SESSION["user"]);
				$manager = $bd->GetManager($user->getId());
				$manager = $manager->fetch_assoc();
				
				$_SESSION['cinema'] = $manager["idcinema"];
			}
		}
		
		$state = isset($_GET['state']) ? $_GET['state'] : '';
		
		switch($state){
			case "view_user":
				$_SESSION["lastRol"] = $_SESSION["rol"];
				$_SESSION["rol"] = null;
				unset($_SESSION["cinema"]);
				$panel = "<div class='row'>
							<div class='column side'></div>
							<div class='column middle'>
								<div class='code info'>
									<h1> ¡ATENCIÓN! </h1><hr />
									<p>Está viendo la web como un Usuario NO Registrado.</p>
									<a href='".$prefix."'><button>Cerrar Mensaje</button></a>
								</div>
							</div>
							<div class='column side'></div>
						</div>
						";
				break;
			case "view_ruser":
				$_SESSION["lastRol"] = $_SESSION["rol"];
				$_SESSION["rol"] = "user";
				unset($_SESSION["cinema"]);
				$panel = "<div class='row'>
							<div class='column side'></div>
							<div class='column middle'>
								<div class='code info'>
									<h1> ¡ATENCIÓN! </h1><hr />
									<p>Está viendo la web como un Usuario Registrado.</p>
									<a href='".$prefix."'><button>Cerrar Mensaje</button></a>
								</div>
							</div>
							<div class='column side'></div>
						</div>
						";
				break;			
			case "manage_halls":
				$panel = Manager_panel::manage_halls();
				break;
			case "new_hall":
				$panel = Manager_panel::new_hall();
				break;	
			case "edit_hall":
				$panel = Manager_panel::edit_hall();
				break;	
			case "manage_sessions":
				$panel = Manager_panel::calendar();
				break;
			case "success":
				$panel = Manager_panel::success();
				break;
			default:  
				$panel = Manager_panel::welcome();
				break;
		}
    }
    else{
        $panel = '<div class="column side"></div>
                   <div class="column middle">
						<div class="code info">
                            <h1>Debes iniciar sesión para ver el Panel de Manager.</h1><hr />
                            <p>Inicia Sesión con una cuenta de Gerente.</p>
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


<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<script src="../assets/js/sessionCalendar.js"></script>
<script src="../assets/js/sessionFormProcess.js"></script>
