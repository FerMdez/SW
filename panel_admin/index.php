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
                                    if(isset($_GET["cinema"])){
                                       // $reply = AdminPanel::showHalls($_GET["cinema"]);
                                       /* if(isset($_GET["number"])) {
                                            $reply = AdminPanel::showHalls($_GET["cinema"], $_GET["number"]);
                                        }
                                        else { */
                                            $reply = AdminPanel::showHalls($_GET["cinema"]);
                                        //}
                                    }
                                    else {
                                        $reply=AdminPanel::addCinema();
                                        $reply.= ($template->print_cinemas()); 
                                    }
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
                        $reply=AdminPanel::see_like_user();
                        break;
                    case 'ur': 
                        $reply=AdminPanel::see_like_registed_user(); 
                        break;
                    case 'ag': 
                        $reply=AdminPanel::see_like_manager();
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