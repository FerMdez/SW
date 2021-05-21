<?php

    class AdminPanel {
        private $state;
        private $login;
        private $prefix;

        function __construct(){}


        function getTemplate(){
            return $this->template;
        }

        static function panel(){
            return $reply=  '<div class="code info">
            <h1>Bienvenido al Panel de Administrador.</h1>
            <hr />
            </div>'."\n"; 
        }

        //Functions FILMS
        static function addFilm(){
            include_once('./includes/formAddFilm.php');
            $formAF = new formAddFilm();
            $htmlAForm = $formAF->gestiona();
            return $reply=   '<!-- Add film -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlAForm."\n";
        }
    
        static function deleteFilm() {
            include_once('./includes/formDeleteFilm.php');
            $formDF = new formDeleteFilm();
            $htmlDForm = $formDF->gestiona();
            return $reply=   '<!-- Add film -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlDForm.'
                    </div>'."\n";
        }

        static function editFilm() {
            include_once('./includes/formEditFilm.php');
            $formEF = new formEditFilm();
            $htmlDForm = $formEF->gestiona();
            return $reply=  '<!-- Add film -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlDForm.'
                    </div>'."\n";
        }

         //Functions Cinemas
         static function addCinema(){
            include_once('./includes/formAddCinema.php');
            $formAC = new formAddCinema();
            $htmlAForm = $formAC->gestiona();
            return $reply=   '<!-- Add cinema -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlAForm.'
                    </div>'."\n";
        }
    
        static function deleteCinema() {
            include_once('./includes/formDeleteCinema.php');
            $formDC = new formDeleteCinema();
            $htmlDForm = $formDC->gestiona();
            return $reply=  '<!-- Delete cinema -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlDForm.'
                    </div>'."\n";
        }

        static function editCinema() {
            include_once('./includes/formEditCinema.php');
            $formEC = new formEditCinema();
            $htmlDForm = $formEC->gestiona();
            return $reply=  '<!-- Edit cinema -->
            <div class="column side"></div>
                    <div class="column middle">
                    '.$htmlDForm.'
                    </div>'."\n";
        }


        //Functions MANAGERS
        static function print_managers(){
            include_once('../assets/php/includes/manager_dao.php');
            include_once('../assets/php/includes/manager.php');
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
            $reply= "<div class='row'>
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
                    $reply.= '<tr>
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
            $reply.='</tbody>
                    </table>
                </div>
                <div class="column side"></div>
            </div>
            ';
            return $reply;
        }
        static function showAddBotton() {
            return $reply = '<div class="column side"></div>
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
        static function addManager(){
            include_once('./includes/formAddManager.php');
            $formAM = new formAddManager();
            $htmlAForm = $formAM->gestiona();
            return $reply=   '<!-- ADD MANAGER -->
                <div class="column side"></div>
                <div class="column middle">
                    <h3>AÑADIR GERENTE</h3>
                    '.$htmlAForm.'
                </div>
                <div class="column side"></div>'."\n";
        }
        static function editManager(){
            include_once('./includes/formEditManager.php');
            $formEM = new formEditManager();
            $htmlEForm = $formEM->gestiona();
            return $reply=   '<!-- EDIT MANAGER -->
                <div class="column side"></div>
                <div class="column middle">
                    <h3>EDITAR GERENTE</h3>
                    '.$htmlEForm.'
                </div>
                <div class="column side"></div>'."\n";
        }

        static function deleteManager(){
            include_once('./includes/formDeleteManager.php');
            $formDM = new formDeleteManager();
            $htmlDForm = $formDM->gestiona();
            return $reply=  '<!-- DELETE MANAGER -->
                <div class="column side"></div>
                <div class="column middle">
                    <h3>ELIMINAR GERENTE</h3>
                    '.$htmlDForm.'
                </div>
                <div class="column side"></div>'."\n";
        }


        //Functions PROMOTIONS
        static function addPromotion(){
            include_once('./includes/formAddPromotion.php');
            $formAP = new formAddPromotion();
            $htmlAForm = $formAP->gestiona();
            return $reply=   '<!-- ADD PROMOTION -->
                <div class="column side"></div>
                <div class="column middle">
                    <h3>AÑADIR PROMOCIÓN</h3>
                    '.$htmlAForm.'
                </div>
                <div class="column side"></div>'."\n";
        }

         static function editPromotion(){
            include_once('./includes/formEditPromotion.php');
            $formEP = new formEditPromotion();
            $htmlEForm = $formEP->gestiona();
            return $reply=  '<!-- EDIT MANAGER -->
                <div class="column side"></div>
                <div class="column middle">
                    <h3>EDITAR PROMOCIÓN</h3>
                    '.$htmlEForm.'
                </div>
                <div class="column side"></div>'."\n";
        }

        static function deletePromotion(){
            include_once('./includes/formDeletePromotion.php');
            $formDP = new formDeletePromotion();
            $htmlDForm = $formDP->gestiona();
            return $reply=  '<!-- DELETE MANAGER -->
            <div class="column side"></div>
                    <div class="column middle">
                    <h3>ELIMINAR PROMOCIÓN</h3>
                    '.$htmlDForm.'
                    </div>'."\n";
        }
        
        static function print_promotions(){
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
            
             $reply= "<div class='row'>
                    
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
                $reply.= '<tr>
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
             $reply.='</tbody>
                         </table>
                        </div>
                        <div class="column side"></div>
                    </div> 
            ';
              return  $reply ;
        }
        
    }
   
?>



