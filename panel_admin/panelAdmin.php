<?php

    class Panel {
        private $state;
        private $login;
        private $prefix;

        function __construct($panel, $login){
            $this->state = $panel;
            $this->login= $login;
        }

        function showPanel($template) {
            $this->prefix = $template->get_prefix();
            if($this->login){
                switch($this->state) {
                    case 'mc': if(isset($_POST['edit_cinema'])) {
                                    $this->editCinema();
                                }
                                else if(isset($_POST['delete_cinema'])) {
                                    $this->deleteCinema();
                                }                             
                                else {
                                    $this-> addCinema();
                                echo ($template->print_cinemas());
                                
                                };  
                    break;
                    case 'mf': if(isset($_POST['edit_film'])) {
                                $this->editFilm();
                            }
                            else if(isset($_POST['delete_film'])) {
                                $this->deleteFilm();
                            }
                            else {
                                $this->addFilm();
                                echo( $template->print_fimls());
                            };  
                    break;
                    case 'mp': 
                                if(isset($_POST['edit_promotion'])) {
                                    $this->editPromotion();
                                }
                                else if(isset($_POST['delete_promotion'])) {
                                    $this->deletePromotion();
                                }
                                else {
                                    $this->addPromotion();
                                    $this->print_promotions();
                                
                                }; 
                    break;
                    case 'mg': if(isset($_POST['edit_manager'])) {
                                    $this->editManager();
                                }
                                else if(isset($_POST['delete_manager'])) {
                                    $this->deleteManager();
                                }
                                else if(isset($_POST['add_manager'])) {
                                    $this->addManager();
                                }
                                
                                else {
                                    $this->showAddBotton();
                                    $this->print_managers();
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
                    default: echo '<div class="code info">
                        <h1>Bienvenido al Panel de Administrador.</h1>
                        <hr />
                    </div>'."\n"; break;
                }
            }
            else {
                echo '<div class="column side"></div>
                <div class="column middle">
                    <div class="code info">
                        <h1>No tienes permiso de administrador.</h1><hr />
                        <p>Inicia Sesión con una cuenta de administtación.</p>
                        <a href="'.$this->prefix.'login/"><button>Iniciar Sesión</button></a>
                    </div>
                </div>
                <div class="column side"></div>'."\n";
            }
        }

        function getTemplate(){
            return $this->template;
        }

        //Functions FILMS
        function addFilm(){
            include_once('./includes/formAddFilm.php');
            $formAF = new formAddFilm();
            $htmlAForm = $formAF->gestiona();
            echo   '<!-- Add film -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlAForm.'
                    </div>'."\n";
        }
    
        function deleteFilm() {
            include_once('./includes/formDeleteFilm.php');
            $formDF = new formDeleteFilm();
            $htmlDForm = $formDF->gestiona();
            echo   '<!-- Add film -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlDForm.'
                    </div>'."\n";
        }
        function editFilm() {
            include_once('./includes/formEditFilm.php');
            $formEF = new formEditFilm();
            $htmlDForm = $formEF->gestiona();
            echo   '<!-- Add film -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlDForm.'
                    </div>'."\n";
        }

         //Functions Cinemas
         function addCinema(){
            include_once('./includes/formAddCinema.php');
            $formAC = new formAddCinema();
            $htmlAForm = $formAC->gestiona();
            echo   '<!-- Add cinema -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlAForm.'
                    </div>'."\n";
        }
    
        function deleteCinema() {
            include_once('./includes/formDeleteCinema.php');
            $formDC = new formDeleteCinema();
            $htmlDForm = $formDC->gestiona();
            echo   '<!-- Delete cinema -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlDForm.'
                    </div>'."\n";
        }

        function editCinema() {
            include_once('./includes/formEditCinema.php');
            $formEC = new formEditCinema();
            $htmlDForm = $formEC->gestiona();
            echo   '<!-- Edit cinema -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlDForm.'
                    </div>'."\n";
        }


        //Functions MANAGERS
        function print_managers(){
            include_once('../assets/php/common/manager_dao.php');
            include_once('../assets/php/common/manager.php');
            $manager = new Manager_DAO("complucine");
            $managers = $manager->allManagersData();
            $ids = array();
            $idscinemas = array();
            $usernames = array();
            $email = array();
            $rol = array();
            if(is_array($managers)){  
                foreach($managers as $key => $value){
                    $ids[$key] = $value->getId();
                    $idscinemas[$key] = $value->getIdcinema();
                    $usernames[$key] = $value->getUsername();
                    $email[$key] = $value->getEmail();
                    $rol[$key] = $value->getRoll();
                }
            }
            echo "<div class='row'>
                    <div class='column side'></div>
                    <div class='column middle'>
                        <table class='alt'>
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>IdCinema</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                        </tr>
                        </thead>
                        <tbody>
                        "; 
            if(is_array($managers)){        
                for($i = 0; $i < count($managers); $i++){
                    echo '<tr>
                            <td>'. $ids[$i] .'</td>
                            <td>'. $idscinemas[$i] .'</td>
                            <td>'. $usernames[$i] .'</td>
                            <td>'. $email[$i] .'</td>
                            <td>'. $rol[$i] .'</td>
                            <td>
                                <form method="post" action="index.php?state=mg">
                                    <input  name="id" type="hidden" value="'.$ids[$i].'">
                                    <input  name="idcinema" type="hidden" value="'.$idscinemas[$i].'">
                                    <input type="submit" id="submit" value="Editar" name="edit_manager" class="primary" />
                                </form> 
                            </td> 
                            <td> 
                                <form method="post" action="index.php?state=mg">
                                    <input  name="id" type="hidden" value="'.$ids[$i].'">
                                    <input  name="idcinema" type="hidden" value="'.$idscinemas[$i].'">
                                    <input  name="username" type="hidden" value="'.$usernames[$i].'">
                                    <input  name="email" type="hidden" value="'.$email[$i].'">
                                    <input  name="rol" type="hidden" value="'.$rol[$i].'">
                                    <input type="submit" id="submit" value="Eliminar" name="delete_manager" class="primary" />
                                </form> 
                            </td> 
                        </tr>
                        '; 
                } 
            }
            echo'</tbody>
                    </table>
                </div>
                <div class="column side"></div>
            </div>
            ';
        }
        function showAddBotton() {
            echo'   <div class="column side"></div>
                    <div class="column middle">
                        <h2>Añadir gerente</h2>
                        <form method="post" action="index.php?state=mg">
                            <div class="actions"> 
                                <input type="submit" id="submit" value="Añadir gerente" name="add_manager" class="primary" />      
                            </div>
                        </form>
                    </div>
                <div class="column side"></div>
            </div>
                ';
        }
        function addManager(){
            include_once('./includes/formAddManager.php');
            $formAM = new formAddManager();
            $htmlAForm = $formAM->gestiona();
            echo   '<!-- ADD MANAGER -->
                <div class="column side"></div>
                <div class="column middle">
                    <h3>AÑADIR GERENTE</h3>
                    '.$htmlAForm.'
                </div>
                <div class="column side"></div>'."\n";
        }
        function editManager(){
            include_once('./includes/formEditManager.php');
            $formEM = new formEditManager();
            $htmlEForm = $formEM->gestiona();
            echo   '<!-- EDIT MANAGER -->
                <div class="column side"></div>
                <div class="column middle">
                    <h3>EDITAR GERENTE</h3>
                    '.$htmlEForm.'
                </div>
                <div class="column side"></div>'."\n";
        }

        function deleteManager(){
            include_once('./includes/formDeleteManager.php');
            $formDM = new formDeleteManager();
            $htmlDForm = $formDM->gestiona();
            echo   '<!-- DELETE MANAGER -->
                <div class="column side"></div>
                <div class="column middle">
                    <h3>ELIMINAR GERENTE</h3>
                    '.$htmlDForm.'
                </div>
                <div class="column side"></div>'."\n";
        }


        //Functions PROMOTIONS
        function addPromotion(){
            include_once('./includes/formAddPromotion.php');
            $formAP = new formAddPromotion();
            $htmlAForm = $formAP->gestiona();
            echo   '<!-- ADD PROMOTION -->
                <div class="column side"></div>
                <div class="column middle">
                    <h3>AÑADIR PROMOCIÓN</h3>
                    '.$htmlAForm.'
                </div>
                <div class="column side"></div>'."\n";
        }
        function editPromotion(){
            include_once('./includes/formEditPromotion.php');
            $formEP = new formEditPromotion();
            $htmlEForm = $formEP->gestiona();
            echo   '<!-- EDIT MANAGER -->
                <div class="column side"></div>
                <div class="column middle">
                    <h3>EDITAR PROMOCIÓN</h3>
                    '.$htmlEForm.'
                </div>
                <div class="column side"></div>'."\n";
        }

        function deletePromotion(){
            include_once('./includes/formDeletePromotion.php');
            $formDP = new formDeletePromotion();
            $htmlDForm = $formDP->gestiona();
            echo   '<!-- DELETE MANAGER -->
            <div class="column side"></div>
                    <div class="column middle">
                    <h3>ELIMINAR PROMOCIÓN</h3>
                    '.$htmlDForm.'
                    </div>'."\n";
        }
        
        function print_promotions(){
            $promo = new Promotion_DAO("complucine");
            $promos = $promo->allPromotionData();
            $ids = array();
            $tittles = array();
            $descriptions = array();
            $codes = array();
            $actives = array();
    
            if(is_array($promos)){ 
                foreach($promos as $key => $value){
                    $ids[$key] = $value->getId();
                    $tittles[$key] = $value->getTittle();
                    $descriptions[$key] = $value->getDescription();
                    $codes[$key] = $value->getCode();
                    $actives[$key] = $value->getActive();
                }
            }
            
            echo "
                <div class='column middle'>
                    <table class='alt'>
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Título</th>
                        <th>Descripcion</th>
                        <th>Código</th>
                        <th>Activo</th>
                    </tr>
                    </thead>
                    <tbody>
                    "; 
            if(is_array($promos)){         
            for($i = 0; $i < count($promos); $i++){
                echo '<tr>
                        <td>'. $ids[$i] .'</td>
                        <td>'. $tittles[$i] .'</td>
                        <td>'. $descriptions[$i] .'</td>
                        <td>'. $codes[$i] .'</td>
                        <td>'. $actives[$i] .'</td>
                        <td>
                            <form method="post" action="index.php?state=mp">
                                <input  name="id" type="hidden" value="'.$ids[$i].'">
                                <input  name="tittle" type="hidden" value="'.$tittles[$i].'">
                                <input  name="description" type="hidden" value="'.$descriptions[$i].'">
                                <input  name="code" type="hidden" value="'.$codes[$i].'">
                                <input  name="active" type="hidden" value="'.$actives[$i].'">
                                <input type="submit" id="submit" value="Editar" name="edit_promotion" class="primary" />
                            </form> 
                        </td> 
                        <td> 
                            <form method="post" action="index.php?state=mp">
                                <input  name="id" type="hidden" value="'.$ids[$i].'">
                                <input  name="tittle" type="hidden" value="'.$tittles[$i].'">
                                <input  name="description" type="hidden" value="'.$descriptions[$i].'">
                                <input  name="code" type="hidden" value="'.$codes[$i].'">
                                <input  name="active" type="hidden" value="'.$actives[$i].'">
                                <input type="submit" id="submit" value="Eliminar" name="delete_promotion" class="primary" />
                            </form> 
                        </td> 
                    </tr>
                    '; 
            } 
            }
            echo'</tbody>
                    </table>
                </div>
                <div class="column side"></div> 
            ';
                
        }
    }
   
?>

