<?php
    class Panel {
        private $state;
        private $login;

        function __construct($panel, $login){
            $this->state = $panel;
            $this->login= $login;
        }

        function showPanel($template) {
            if($this->login){
                switch($this->state) {
                    case 'mc': if(isset($_POST['edit_cinema'])) {
                                $this->editCinema();
                            }
                            else if(isset($_POST['delete_cinema'])) {
                                $this->deleteCinema();
                            }
                            else if(isset($_POST['add_cinema'])) {
                                $this->addCinema();
                                $template->print_cinemas();
                            }                               
                            else {
                                $this-> addCinema();
                                $template->print_cinemas();
                            
                            };  
                    break;
                    case 'mf': if(isset($_POST['edit_film'])) {
                                $this->editFilm();
                                }
                            else if(isset($_POST['delete_film'])) {
                                $this->deleteFilm();
                            }
                            else if(isset($_POST['add_film'])) {
                                $this->addFilm();
                                $template->print_fimls();
                            }
                            else {
                                $this->addFilm();
                                $template->print_fimls();
                            };  
                    break;
                    case 'mp': require_once('manage_promotions.php');
                                if(isset($_POST['edit_promotion'])) {
                                    editPromotion();
                                }
                                else if(isset($_POST['delete_promotion'])) {
                                    deletePromotion();
                                }
                                else if(isset($_POST['add_promotion'])) {
                                    confirmAdd();
                                }
                                else if(isset($_POST['confirm_delete_promotion'])) {
                                    confirmDelete();
                                }
                                else if(isset($_POST['confirm_edit_promotion'])) {
                                    confirmEdit();
                                }
                                else {
                                    addPromotion();
                                    print_promotions();
                                
                                }; 
                    break;
                    case 'mg': require_once('manage_managers.php');
                    if(isset($_POST['edit_manager'])) {
                        editManager();
                    }
                    else if(isset($_POST['delete_manager'])) {
                        deleteManager();
                    }
                    else if(isset($_POST['select_user'])) {
                        selectUser();
                    }
                    else if(isset($_POST['select_cinema'])) {
                        selectCinema();
                    }
                    else if(isset($_POST['add_manager'])) {
                        confirmAdd();
                    }
                   
                    else if(isset($_POST['confirm_delete_manager'])) {
                        confirmDelete();
                    }
                    else if(isset($_POST['confirm_edit_manager'])) {
                        confirmEdit();
                    }
                    else {
                        addManager();
                        print_managers();
                    
                    }; 
                    break;
                    case 'un': echo"<h1>En construcción</h1>"; break;
                    case 'ur': echo"<h1>En construcción</h1>";; break;
                    case 'ag': echo"<h1>En construcción</h1>";; break;
                    default: echo "<h1>BIENVENIDO AL PANEL DE ADMINISTRADOR</h1>"; break;
                }
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
                    include_once('./includes/formEditFilm.php');
                    $formEF = new formEditCinema();
                    $htmlDForm = $formEC->gestiona();
                    echo   '<!-- Edit cinema -->
                    <div class="column side"></div>
                            <div class="column middle">
                            '.$htmlDForm.'
                            </div>'."\n";
                }
            }
           
?>
