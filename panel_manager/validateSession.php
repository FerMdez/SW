<?php
	//General Config File:
    require_once('../assets/php/config.php');
    require_once('./includes/formSession.php');
    $session = new FormSession();
	$reply = "<p> ERROR DE ACCESO </p>" ;
	
	if(isset($_POST['new'])){
		$session->processesForm($_POST["film"], $_POST["hall"], $_SESSION["cinema"],$_POST["date"],$_POST["start"],$_POST["price"],$_POST["format"],$_POST["repeat"], "new");
		$reply = $session->getReply();
		$_SESSION["cinema"] = "";
		$_SESSION["hall"] =	"";
		$_SESSION["date"] = "";
		$_SESSION["start"] = "";
		
	} else if (isset($_POST['edit'])){
		$session->processesForm($_POST["film"], $_POST["hall"], $_SESSION["cinema"],$_POST["date"],$_POST["start"],$_POST["price"],$_POST["format"],"0", "edit");
		$reply = $session->getReply();
				$_SESSION["cinema"] = "";
		$_SESSION["hall"] =	"";
		$_SESSION["date"] = "";
		$_SESSION["start"] = "";
		 
	} else if (isset($_POST['del'])){
		$session->processesForm($_POST["film"], $_POST["hall"], $_SESSION["cinema"],$_POST["date"],$_POST["start"],$_POST["price"],$_POST["format"],"0", "del");
		$reply = $session->getReply();
		$_SESSION["cinema"] = "";
		$_SESSION["hall"] =	"";
		$_SESSION["date"] = "";
		$_SESSION["start"] = "";
	}

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