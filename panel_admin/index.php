<?php
    //General Config File:
    include_once('../assets/php/config.php');
    
    require_once($prefix.'panel_admin/panelAdmin.php');


    if(($_SESSION["login"]) && $_SESSION["rol"] == "admin"){
    if(!isset($_GET["state"]))
        $_GET["state"] =null;
        switch($_GET["state"]){
                    case 'mc': if(isset($_POST['edit_cinema'])) {
                                    $reply=AdminPanel::editCinema();
                                }
                                else if(isset($_POST['delete_cinema'])) {
                                    $reply=AdminPanel::deleteCinema();
                                }                             
                                else {
                                    $reply=AdminPanel::addCinema();
                                    $reply.= ($template->print_cinemas()); 
                                };  
                    break;
                    case 'mf': if(isset($_POST['edit_film'])) {
                                $reply=AdminPanel::editFilm();
                            }
                            else if(isset($_POST['delete_film'])) {
                                $reply=AdminPanel::deleteFilm();
                            }
                            else {
                                $reply=AdminPanel::addFilm();
                                $reply.= $template->print_fimls();
                            };  
                    break;
                    case 'mp': 
                                if(isset($_POST['edit_promotion'])) {
                                    $reply=AdminPanel::editPromotion();
                                }
                                else if(isset($_POST['delete_promotion'])) {
                                    $reply=AdminPanel::deletePromotion();
                                }
                                else {
                                    $reply=AdminPanel::addPromotion();
                                    $reply.=AdminPanel::print_promotions();
                                
                                }; 
                    break;
                    case 'mg': if(isset($_POST['edit_manager'])) {
                                    $reply=AdminPanel::editManager();
                                }
                                else if(isset($_POST['delete_manager'])) {
                                    $reply=AdminPanel::deleteManager();
                                }
                                else if(isset($_POST['add_manager'])) {
                                    $reply=AdminPanel::addManager();
                                }
                                
                                else {
                                    $reply=AdminPanel::showAddBotton();
                                    $reply.=AdminPanel::print_managers();
                                }; 
                    break;
                    case 'un': 
                        $_SESSION["lastRol"] = $_SESSION["rol"];
                        //unset($_SESSION["rol"]);
                        $_SESSION["rol"] = null;
                        header("Location: {$_SERVER['PHP_SELF']}");
                        $_SESSION['message'] = "<div class='row'>
                                                <div class='column side'></div>
                                                <div class='column middle'>
                                                    <div class='code info'>
                                                        <h1> ¡ATENCIÓN! </h1><hr />
                                                        <p>Está viendo la web como un Usuario NO Registrado.</p>
                                                        <a href=''><button>Cerrar Mensaje</button></a>
                                                    </div>
                                                </div>
                                                <div class='column side'></div>
                                            </div>
                                            ";
                        break;
                    case 'ur': 
                        $_SESSION["lastRol"] = $_SESSION["rol"];
                        $_SESSION["rol"] = "user";
                        header("Location: {$_SERVER['PHP_SELF']}");
                        $_SESSION['message'] = "<div class='row'>
                                                <div class='column side'></div>
                                                <div class='column middle'>
                                                    <div class='code info'>
                                                        <h1> ¡ATENCIÓN! </h1><hr />
                                                        <p>Está viendo la web como un Usuario Registrado.</p>
                                                        <a href=''><button>Cerrar Mensaje</button></a>
                                                    </div>
                                                </div>
                                                <div class='column side'></div>
                                            </div>
                                            ";
                        break;
                    case 'ag': 
                        $_SESSION["lastRol"] = $_SESSION["rol"];
                        $_SESSION["rol"] = "manager";
                        header("Location: {$_SERVER['PHP_SELF']}");
                        $_SESSION['message'] = "<div class='row'>
                                                <div class='column side'></div>
                                                <div class='column middle'>
                                                    <div class='code info'>
                                                        <h1> ¡ATENCIÓN! </h1><hr />
                                                        <p>Está viendo la web como un Gerente.</p>
                                                        <a href=''><button>Cerrar Mensaje</button></a>
                                                    </div>
                                                </div>
                                                <div class='column side'></div>
                                            </div>
                                            ";
                        break;
                    default:
                        $reply=AdminPanel:: panel(); 
                    break;
                }
        }
        else{
            $reply ='<div class="column side"></div>
                        <div class="column middle">
                            <div class="code info">
                                <h1>No tienes permiso de administrador.</h1><hr />
                                <p>Inicia Sesión con una cuenta de administtación.</p>
                                <a href="'.$prefix.'login/"><button>Iniciar Sesión</button></a>
                            </div>
                        </div>
                        <div class="column side"></div>'."\n";
        }
        
        $section = '<!-- Manager Admin -->
        <section id="admin_panel">
			<!-- Contents -->
			<div class="row">
				'.$reply.'
			</div>
        </section>';

        require RAIZ_APP.'/HTMLtemplate.php';
            
?>