<!DOCTYPE HTML>
<?php

    /**
     * USUARIOS DE PRUEBAS:
     * user | userpass
     * fernando | ferpass
     * manager | managerpass
     * admin | adminpass
     */
    
    //General Config File:
    require_once('../assets/php/config.php');        

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
        <?php
            $template->print_main();
        ?>
        
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
