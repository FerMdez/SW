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
                    case 'mc': require_once('manage_cinemas.php');
                                if(isset($_POST['edit_cinema'])) {
                                    editCinema();
                                }
                                else if(isset($_POST['delete_cinema'])) {
                                    deleteCinema();
                                }
                                else if(isset($_POST['add_cinema'])) {
                                    confirmAdd();
                                }
                                else if(isset($_POST['confirm_delete_cinema'])) {
                                    confirmDelete();
                                }
                                else if(isset($_POST['confirm_edit_cinema'])) {
                                    confirmEdit();
                                }
                                else {
                                    addCinema();
                                    $template->print_cinemas();
                                   
                                }; 
                    break;
                    case 'mf': require_once('manage_films.php'); 
                            if(isset($_POST['edit_film'])) {
                                editFilm();
                            }
                            else if(isset($_POST['delete_film'])) {
                                deleteFilm();
                            }
                            else if(isset($_POST['add_film'])) {
                                confirmAdd();
                            }
                            else if(isset($_POST['confirm_delete_film'])) {
                                confirmDelete();    
                            }
                            else if(isset($_POST['confirm_edit_film'])) {
                                confirmEdit();
                            }
                            else {
                                addFilm();
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
            else {
                echo "<h1>NO TIENES PERMISOS DE ADMINISTRADOR</h1>";
            }
        }

        function getTemplate(){
            return $this->template;
        }
    }
?>

