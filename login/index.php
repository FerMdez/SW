<!DOCTYPE HTML>
<?php
    session_start();

    //HTML template:
    require_once('../assets/php/template.php');
    $template = new Template();    

    //Change the view of the "Login page" to "Registration page":
    require('login_register_view.php');
    $view = new LoginRegisterView();
    $isLogin = $view->getIsLogin();
    $login = $view->getLogin();
    $register = $view->getRegister();
?>
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
            <h1>Acceso</h1>
            <hr />
        </div>
        
        <!-- Login / Register -->
        <section id="login_register">
			<div class ="row">
                <?php
                    if($isLogin){
                        echo $login;
                    } else {
                        echo $register;
                    }
                ?>
            </div>	
		</section>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>

    </body>

</html>
