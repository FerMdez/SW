<?php
    session_start();
    require_once('../assets/php/template.php');
    $template = new Template();
	$action ="";
	$id = null;
	if(isset($_POST['new'])){
		$action = "new";
	} else if (isset($_POST['edit'])){
		$action = "edit";
		$id = $_POST["id"];
	} else if (isset($_POST['del'])){
		$action = "del";
		$id = $_POST["id"];
	}
	
    //Login form validate:
    require_once('./includes/formFilm.php');
    $session = new FormFilm();
    $session->processesForm($id, $_POST["title"], $_POST["duration"], $_POST["languaje"],$_POST["description"], $action);
    $reply = $session->getReply();
?>
<!DOCTYPE HTML>
<!--
    Práctica 2 - Sistemas Web | Grupo D
    CompluCine - FDI-cines
-->
<html lang="es">
    <!-- Head -->
    <?php
        $template->print_head();
    ?>
    <body>
        <!-- Header -->
        <?php
            $template->print_header();
        ?>

        <!-- Main -->
        <div class="main">
            <div class="image"><img src="../img/logo_trasparente.png" /></div>
        </div>
        
        <!-- Reply -->
        <section class="reply">
            <div class ="row">
                <div class="column side"></div>
                <div class="column middle">
                    <div class="code info">
                        <?php
                            echo $reply;
                        ?>
                    </div>
                </div>
                <div class="column side"></div>    
            </div>
        </section>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>

    </body>

</html>