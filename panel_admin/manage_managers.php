<?php

    //General Config File:
    include_once('../assets/php/config.php');

    include_once('../assets/php/common/manager.php');

    include_once('../assets/php/common/cinema_dao.php');

    include_once('../assets/php/common/user_dao.php');

    include_once(__DIR__.'/includes/formManager.php');	

   
    // View functions
    function print_managers(){
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
                    <th>password</th>
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
                                <input  name="username" type="hidden" value="'.$usernames[$i].'">
                                <input  name="email" type="hidden" value="'.$email[$i].'">
                                <input  name="rol" type="hidden" value="'.$rol[$i].'">
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
        ';

        
            
    }

    function addManager(){
        echo'   <div class="column side"></div>
                <div class="column middle">
                    <h2>Añadir gerente</h2>
                    <form method="post" action="index.php?state=mg">
                        <div class="actions"> 
                            <input type="submit" id="submit" value="Añadir gerente" name="select_user" class="primary" />      
                        </div>
                    </form>
                </div>
                <div class="column side"></div>
            </div>
            ';
    }
   
    function selectUser() {
        echo'<div class="column side"></div>
        <div class="column middle">
            <h2>Selecciona el usuario al que quieres dar privilegios.</h2>
            <form method="post" action="index.php?state=mg">
                <div class="row">
                <fieldset id="manager_form">
                    <legend>Selecciona usuario.</legend>';
        
        showUsers();          
        echo '</fieldset>
                    <div class="actions"> 
                        <input type="submit" id="submit" value="Seleccionar" name="select_cinema" class="primary" />
                        <input type="reset" id="reset" value="Borrar" />       
                        </div>
                    </div>
            </form>
        </div>
        <div class="column side"></div>
        ';

    }

    function selectCinema() {
        echo'<div class="column side"></div>
        <div class="column middle">
            <h2>Selecciona el cine asociado al nuevo manager.</h2>
            <form method="post" action="index.php?state=mg">
                <div class="row">
                <fieldset id="manager_form">
                    <legend>Selecciona cine.</legend>';
        
        showCinemas();          
        echo '</fieldset>
                    <div class="actions"> 
                        <input  name="iduser" type="hidden" value="'.$_POST['iduser'].'">
                        <input type="submit" id="submit" value="Seleccionar" name="add_manager" class="primary" />
                        <input type="reset" id="reset" value="Borrar" />       
                        </div>
                    </div>
            </form>
        </div>
        <div class="column side"></div>
        ';

    }
    function deleteManager() {
        echo'<div class="column side"></div>
            <div class="column middle">
                <h2>Borrar gerente</h2>
                <form method="post" action="index.php?state=mg">
                    <div class="row">
                        <fieldset id="promotion_form">
                            <legend>¿Estás seguro de que quieres eliminar este gerente?</legend>
                            <input type="hidden" name="id" value='.$_POST['id'].'/>
                            <p>Id: '.$_POST['id'].' </p>
                            <p>IdCinema: '.$_POST['idcinema'].' </p>
                            <p>Nombre: '.$_POST['username'].' </p>
                            <p>Email: '.$_POST['email'].' </p>
                            <p>Rol: '.$_POST['rol'].' </p>
                        </fieldset>
                        <div class="actions"> 
                            <input type="submit" id="submit" value="Eliminar" name="confirm_delete_manager" class="primary" />
                            <input type="submit" id="submit" value="Cancelar" name="cancel_delete_manager" class="primary" />
                            </div>
                    </div>
                </form>
            </div>
            <div class="column side"></div>
            ';
    }
  

    function editManager() {
       
        echo'<div class="column side"></div>
        <div class="column middle">
            <h2>Editar gerente ID: '.$_POST['id'].'</h2>
            <form method="post" action="index.php?state=mg">
                <div class="row">
                <fieldset id="promotion_form">
                    <legend>Selecciona su cine.</legend>';
                   showCinemas();
        echo '</fieldset>
                    <div class="actions"> 
                        <input type="hidden" name="id" value='.$_POST['id'].'/>
                        <input type="submit" id="submit" value="Editar" name="confirm_edit_manager" class="primary" />
                        <input type="reset" id="reset" value="Borrar" />       
                        </div>
                    </div>
            </form>
        </div>
        <div class="column side"></div>
        ';
                   
    }

    // Show cinemas and users functions
    function showCinemas() {
        $cine = new Cinema_DAO("complucine");
        $cinemas = $cine->allCinemaData();
        $ids = array();
        $names = array();
        $directions = array();
        $phones = array();

        foreach($cinemas as $key => $value){
            $ids[$key] = $value->getId();
            $names[$key] = $value->getName();
            $directions[$key] = $value->getDirection();
            $phones[$key] = $value->getPhone();
        }
        for($i = 0; $i < count($cinemas); $i++){
            echo '
            <input type="radio" name="idcinema" value='.$ids[$i].' >  <label> '.$ids[$i].', '.$names[$i].'
            </label>
            ';
        }
    }
    function showUsers() {
        $user = new UserDAO("complucine");
        $users = $user->allUsersNotM();
        $ids = array();
        $usernames = array();
        $emails = array();
        $roles = array();
        

        foreach($users as $key => $value){
            $ids[$key] = $value->getId();
            $usernames[$key] = $value->getName();
            $emails[$key] = $value->getEmail();
            $roles[$key] = $value->getRol();
        }
        for($i = 0; $i < count($users); $i++){
            echo '
            <input type="radio" name="iduser" value='.$ids[$i].' >  <label> '.$ids[$i].', '.$usernames[$i].', '.$usernames[$key].'
            </label>
            ';
        }
    }

    // Logic Functions
       function confirmDelete() {
        $cine = new FormManager();
        $cine->processesForm($_POST['id'], null,"del");
        $_SESSION['message'] = $cine->getReply();
        header('Location: ../panel_admin/index.php?state=mg');
    }
    function confirmEdit() {
        $manager = new FormManager();
        $manager->processesForm($_POST['id'], $_POST['idcinema'],"edit");
        $_SESSION['message']= $manager->getReply();
        header('Location: ../panel_admin/index.php?state=mg');
    }
    function confirmAdd() {
        $manager = new FormManager();
        $manager->processesForm($_POST['iduser'], $_POST['idcinema'],"new");
        $_SESSION['message'] = $manager->getReply();
        header('Location: ../panel_admin/index.php?state=mg');
    }


?>