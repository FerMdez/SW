<?php

    //General Config File:
    include_once('../assets/php/config.php');

	include_once('../assets/php/common/promotion.php');	
    include_once(__DIR__.'/includes/formPromotion.php');	

 
   
    // View functions
    function print_managers(){
        $manager = new Manager_DAO("complucine");
        $managers = $manager->allManagersData();
        $ids = array();
        $usernames = array();
        $email = array();
        $pass = array();
        $rol = array();

        foreach($managers as $key => $value){
            $ids[$key] = $value->getId();
            $usernames[$key] = $value->getUsername();
            $email[$key] = $value->getEmail();
            $pass[$key] = $value->getPass();
            $rol[$key] = $value->getRoll();
        }

        
        echo "<div class='row'>
            <div class='column side'></div>
            <div class='column middle'>
                <table class='alt'>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>password</th>
                    <th>Rol</th>
                </tr>
                </thead>
                <tbody>
                "; 
        for($i = 0; $i < count($promos); $i++){
            echo '<tr>
                    <td>'. $ids[$i] .'</td>
                    <td>'. $usernames[$i] .'</td>
                    <td>'. $email[$i] .'</td>
                    <td>'. $pass[$i] .'</td>
                    <td>'. $rol[$i] .'</td>
                    <td>
                        <form method="post" action="index.php?state=mp">
                            <input  name="id" type="hidden" value="'.$ids[$i].'">
                            <input  name="username" type="hidden" value="'.$usernames[$i].'">
                            <input  name="email" type="hidden" value="'.$email[$i].'">
                            <input  name="pass" type="hidden" value="'.$pass[$i].'">
                            <input  name="rol" type="hidden" value="'.$rol[$i].'">
                            <input type="submit" id="submit" value="Editar" name="edit_manager" class="primary" />
                        </form> 
                    </td> 
                    <td> 
                        <form method="post" action="index.php?state=mp">
                            <input  name="id" type="hidden" value="'.$ids[$i].'">
                            <input  name="username" type="hidden" value="'.$usernames[$i].'">
                            <input  name="email" type="hidden" value="'.$email[$i].'">
                            <input  name="pass" type="hidden" value="'.$pass[$i].'">
                            <input  name="rol" type="hidden" value="'.$rol[$i].'">
                            <input type="submit" id="submit" value="Eliminar" name="delete_manager" class="primary" />
                        </form> 
                    </td> 
                </tr>
                '; 
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
                    <h2>Añadir promoción</h2>
                    <form method="post" action="index.php?state=mp">
                        <fieldset id="promotion_form">
                        <legend>Datos dela Promoción</legend>
                        <div>
                            <input type="text" name="username" id="username" placeholder="Nombre" />
                        </div>
                        <div>
                            <input type="email" name="email" id="email" placeholder="email" />
                        </div>
                        <div>
                            <input type="text" name="password" id="pass" placeholder="pass" />
                        </div>
                        </fieldset>
                        <div class="actions"> 
                            <input type="submit" id="submit" value="Añadir gerente" name="add_manager" class="primary" />
                            <input type="reset" id="reset" value="Borrar" />       
                        </div>
                    </form>
                </div>
                <div class="column side"></div>
            </div>
            ';
    }
    function deleteManager() {
        echo'<div class="column side"></div>
            <div class="column middle">
                <h2>Editar Promoción</h2>
                <form method="post" action="index.php?state=mp">
                    <div class="row">
                        <fieldset id="promotion_form">
                            <legend>¿Estás seguro de que quieres eliminar este gerente?</legend>
                            <input type="hidden" name="id" value='.$_POST['id'].'/>
                            <p>Id: '.$_POST['id'].' </p>
                            <p>Nombre: '.$_POST['username'].' </p>
                            <p>Email: '.$_POST['email'].' </p>
                            <p>Password: '.$_POST['pass'].' </p>
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
                <h2>Editar promoción</h2>
                <form method="post" action="index.php?state=mp">
                <div class="row">
                <fieldset id="promotion_form">
                    <legend>Datos de la promoción</legend>
                    <input type="hidden" name="id" value='.$_POST['id'].'/>
                    <div>
                        <input type="text" name="username" value="'.$_POST['username'].'" />
                    </div>
                    <div>
                        <input type="email" name="email" value='.$_POST['email'].' />
                    </div>
                    <div>
                        <input type="text" name="pass"  value='.$_POST['pass'].' />
                    </div>
                    </fieldset>
                    <div class="actions"> 
                        <input type="submit" id="submit" value="Editar" name="confirm_edit_manager" class="primary" />
                        <input type="reset" id="reset" value="Borrar" />       
                        </div>
                    </div>
                </form>
            </div>
            <div class="column side"></div>
            ';
    }

    // Logic Functions
       function confirmDelete() {
        $cine = new FormPromotion();
        $cine->processesForm($_POST['id'],null,null,null,null,"del");
        $_SESSION['message'] = $cine->getReply();
        header('Location: ../panel_admin/index.php?state=mp');
    }
    function confirmEdit() {
        $cine = new FormPromotion();
        $cine->processesForm($_POST['id'], $_POST['username'], $_POST['email'], $_POST['pass'],"manager","edit");
        $_SESSION['message']= $cine->getReply();
        header('Location: ../panel_admin/index.php?state=mp');
    }
    function confirmAdd() {
        $cine = new FormPromotion();
        $cine->processesForm(null,$_POST['username'], $_POST['email'], $_POST['pass'],"manager","new");
        $_SESSION['message'] = $cine->getReply();
        header('Location: ../panel_admin/index.php?state=mp');
    }


?>