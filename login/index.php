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
    //Forms:
    require('includes/formLogin.php');
    require('../register/includes/formRegister.php');
    $formLogin = new FormLogin();
    $htmlFormLogin = $formLogin->gestiona();
    $formRegister = new FormRegister();
    $htmlFormRegister = $formRegister->gestiona();
?>
<!DOCTYPE HTML>
<!--
    Práctica - Sistemas Web | Grupo D
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
                    echo "<!-- Login -->
                    <div class='column left'>
                        <div class='code info'>
                            <h2>¿No tienes una cuenta?</h2>
                            <hr />
                            <p>Para crear una cuenta de usuario es necesario haber rellenado el formulario de registro previamente</p>
                            <p>Haz click en el botón para registrate.</p>
                            <form method='post'>
                                <button type='submit' name='register' id='register'>Registrate</button>
                            </form>
                        </div>
                    </div>
                    <div class='column right'>
                        <h2>Iniciar Sesión</h2>
                        ".$htmlFormLogin."
                        </div>"."\n";
                    } else {
                    echo "<!-- Register -->
                    <div class='column left'>
                        <h2>Registro</h2>
                        ".$htmlFormRegister."
                    </div>
                    <div class='column right'>
                        <div class='code info'>
                            <h2>¿Ya estás registrado?</h2>
                            <hr />
                            <p>Si dispones de una cuenta de usuario, no es necesario que rellenes este formulario nuevamente</p>
                            <p>Haz click en el botón para iniciar sesión.</p>
                            <form method='post'>
                                <button type='submit' name='login' id='login'>Inicia Sesión</button>
                            </form>
                        </div>
                    </div>"."\n";
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
