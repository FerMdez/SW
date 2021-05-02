<?php

    //General Config File:
    include_once('../assets/php/config.php');

	include_once('../assets/php/common/cinema.php');	
    include_once(__DIR__.'/includes/formCinema.php');	

 
   
    // View functions
    function addCinema(){
        echo'   <div class="column side"></div>
                <div class="column middle">
                    <h2>Añadir cine</h2>
                    <form method="post" action="index.php?state=mc">
                        <fieldset id="cinema_form">
                        <legend>Datos del Cine</legend>
                        <div>
                            <input type="text" name="name" id="name" placeholder="Nombre" />
                        </div>
                        <div>
                            <input type="text" name="direction" id="direction" placeholder="Direccion" />
                        </div>
                        <div>
                            <input type="text" name="phone" id="phone" placeholder="Teléfono" />
                        </div>
                        </fieldset>
                        <div class="actions"> 
                            <input type="submit" id="submit" value="Añadir cine" name="add_cinema" class="primary" />
                            <input type="reset" id="reset" value="Borrar" />       
                        </div>
                    </form>
                </div>
                <div class="column side"></div>
            </div>
            ';
    }
    function deleteCinema() {
        echo'<div class="column side"></div>
            <div class="column middle">
                <h2>Eliminar cine</h2>
                <form method="post" action="index.php?state=mc">
                    <div class="row">
                    <fieldset id="cinema_form">
                    <legend>¿Estás seguro de que quieres eliminar este cine?</legend>
                    <input type="hidden" name="id" value='.$_POST['id'].'/>
                    <p>Id: '.$_POST['id'].' </p>
                    <p>Nombre: '.$_POST['name'].' </p>
                    <p>Dirección: '.$_POST['direction'].' </p>
                    <p>Teléfono: '.$_POST['phone'].' </p>
                    </fieldset>
                    <div class="actions"> 
                        <input type="submit" id="submit" value="Eliminar" name="confirm_delete_film" class="primary" />
                        <input type="submit" id="submit" value="Cancelar" name="cancel_delete_film" class="primary" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="column side"></div>
            ';
    }
    function editCinema() {
        echo'<div class="column side"></div>
            <div class="column middle">
                <h2>Editar cine</h2>
                <form method="post" action="index.php?state=mc">
                <div class="row">
                <fieldset id="cinema_form">
                    <legend>Datos del cine</legend>
                    <input type="hidden" name="id" value='.$_POST['id'].'/>
                    <div>
                        <input type="text" name="name" value="'.$_POST['name'].'" />
                    </div>
                    <div>
                        <input type="text" name="direction" value='.$_POST['direction'].' />
                    </div>
                    <div>
                        <input type="text" name="phone"  value='.$_POST['phone'].' />
                    </div>
                    </fieldset>
                    <div class="actions"> 
                        <input type="submit" id="submit" value="Editar" name="confirm_edit_cinema" class="primary" />
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
        $cine = new FormCinema();
        $cine->processesForm($_POST['id'],null,null,null,"del");
        $_SESSION['message'] = $cine->getReply();
        header('Location: ../panel_admin/index.php?state=mc');
    }
    function confirmEdit() {
        $cine = new FormCinema();
        $cine->processesForm($_POST['id'], $_POST['name'], $_POST['direction'], $_POST['phone'],"edit");
        $_SESSION['message']= $cine->getReply();
        header('Location: ../panel_admin/index.php?state=mc');
    }
    function confirmAdd() {
        $cine = new FormCinema();
        $cine->processesForm(null, $_POST['name'], $_POST['direction'], $_POST['phone'],"new");
        $_SESSION['message'] = $cine->getReply();
        header('Location: ../panel_admin/index.php?state=mc');
    }


?>