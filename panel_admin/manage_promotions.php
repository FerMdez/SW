<?php

    //General Config File:
    include_once('../assets/php/config.php');

	include_once('../assets/php/common/promotion.php');	
    include_once(__DIR__.'/includes/formPromotion.php');	

 
   
    // View functions
    function print_promotions(){
        $promo = new Promotion_DAO("complucine");
        $promos = $promo->allPromotionData();
        $ids = array();
        $tittles = array();
        $descriptions = array();
        $codes = array();
        $actives = array();

        foreach($promos as $key => $value){
            $ids[$key] = $value->getId();
            $tittles[$key] = $value->getTittle();
            $descriptions[$key] = $value->getDescription();
            $codes[$key] = $value->getCode();
            $actives[$key] = $value->getActive();
        }

        
        echo "<div class='row'>
            <div class='column side'></div>
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
        echo'</tbody>
                </table>
            </div>
            <div class="column side"></div>
        ';
            
    }

    function addPromotion(){
        echo'   <div class="column side"></div>
                <div class="column middle">
                    <h2>Añadir promoción</h2>
                    <form method="post" action="index.php?state=mp">
                        <fieldset id="promotion_form">
                        <legend>Datos dela Promoción</legend>
                        <div>
                            <input type="text" name="tittle" id="tittle" placeholder="Nombre" />
                        </div>
                        <div>
                            <input type="text" name="description" id="description" placeholder="Descripción" />
                        </div>
                        <div>
                            <input type="text" name="code" id="code" placeholder="Código" />
                        </div>
                        <div>
                        <input type="text" name="active" id="active" placeholder="Activo" />
                        </div>
                        </fieldset>
                        <div class="actions"> 
                            <input type="submit" id="submit" value="Añadir promoción" name="add_promotion" class="primary" />
                            <input type="reset" id="reset" value="Borrar" />       
                        </div>
                    </form>
                </div>
                <div class="column side"></div>
            </div>
            ';
    }
    function deletePromotion() {
        echo'<div class="column side"></div>
            <div class="column middle">
                <h2>Editar Promoción</h2>
                <form method="post" action="index.php?state=mp">
                    <div class="row">
                        <fieldset id="promotion_form">
                            <legend>¿Estás seguro de que quieres eliminar esta promoción?</legend>
                            <input type="hidden" name="id" value='.$_POST['id'].'/>
                            <p>Id: '.$_POST['id'].' </p>
                            <p>Título: '.$_POST['tittle'].' </p>
                            <p>Descripción: '.$_POST['description'].' </p>
                            <p>Código: '.$_POST['code'].' </p>
                            <p>Activa: '.$_POST['active'].' </p>
                        </fieldset>
                        <div class="actions"> 
                            <input type="submit" id="submit" value="Eliminar" name="confirm_delete_promotion" class="primary" />
                            <input type="submit" id="submit" value="Cancelar" name="cancel_delete_promotion" class="primary" />
                            </div>
                    </div>
                </form>
            </div>
            <div class="column side"></div>
            ';
    }
    function editPromotion() {
        echo'<div class="column side"></div>
            <div class="column middle">
                <h2>Editar promoción</h2>
                <form method="post" action="index.php?state=mp">
                <div class="row">
                <fieldset id="promotion_form">
                    <legend>Datos de la promoción</legend>
                    <input type="hidden" name="id" value='.$_POST['id'].'/>
                    <div>
                        <input type="text" name="tittle" value="'.$_POST['tittle'].'" />
                    </div>
                    <div>
                        <input type="text" name="description" value='.$_POST['description'].' />
                    </div>
                    <div>
                        <input type="text" name="code"  value='.$_POST['code'].' />
                    </div>
                    <div>
                    <input type="text" name="active"  value='.$_POST['active'].' />
                    </div>
                    </fieldset>
                    <div class="actions"> 
                        <input type="submit" id="submit" value="Editar" name="confirm_edit_promotion" class="primary" />
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
        $cine->processesForm($_POST['id'], $_POST['tittle'], $_POST['description'], $_POST['code'],$_POST['active'],"edit");
        $_SESSION['message']= $cine->getReply();
        header('Location: ../panel_admin/index.php?state=mp');
    }
    function confirmAdd() {
        $cine = new FormPromotion();
        $cine->processesForm(null,$_POST['tittle'], $_POST['description'], $_POST['code'],$_POST['active'],"new");
        $_SESSION['message'] = $cine->getReply();
        header('Location: ../panel_admin/index.php?state=mp');
    }


?>