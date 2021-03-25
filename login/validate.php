<?php
    session_start();

    require_once('../assets/php/template.php');
    $template = new Template();

    //Borrar array cuando tengamos BD:
    $_users = array(
        "user" => "userpass",
        "manager" => "managerpass",
        "admin" => "adminpass"
    );

    $name = test_input($_POST["name"]); 
    $passwd = test_input($_POST["pass"]);
    $login = false;
    $rol = "user";
    $nombre;

    function test_input($input){
        return htmlspecialchars(trim(strip_tags($input)));
    }

    foreach($_users as $clave => $valor){
        if($clave == $name  && $valor == $passwd){
            $login = true;
            if($name == "admin"){
                $nombre = "Administrador"; //CAMBIAR POR EL NOMBRE DE USUARIO, CUANDO ESTÉ LA BBDD
                $rol = "admin";
                
            } 
            else if($name == "manager"){
                $nombre = "Gerente"; //CAMBIAR POR EL NOMBRE DE USUARIO, CUANDO ESTÉ LA BBDD
                $rol = "manager";
            }
            else{
                $nombre = "Usuario"; //CAMBIAR POR EL NOMBRE DE USUARIO, CUANDO ESTÉ LA BBDD
            }
            $_SESSION["nombre"] = $nombre;
            $_SESSION["login"] = $login;
            $_SESSION["rol"] = $rol;
            
            $reply = "<h1>Bienvenido {$_SESSION['nombre']}</h1><hr />
                        <p>{$_SESSION['nombre']} has iniciado sesión correctamente.</p>
                        <p>Usa los botones para navegar</p>
                        <a href='../'><button>Inicio</button></a>
                        <a href='../panel_{$rol}'><button>Mi Panel</button></a>\n";
            /*
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = '';
            header("Location: http://$host$uri/$extra");
            exit;
            */
        }
    }

    if(!isset($_SESSION["login"])){
        $reply = "<h1>ERROR</h1><hr />".
                    "<p>El usuario o contraseña no son válidos.</p>
                        <p>Vuelve a intetarlo o regístrate si no lo habías hecho previamente.</p>
                        <a href='./'><button>Iniciar Sesión</button></a>
                        <form method='post' action='./'><button name='register' id='register'>Registro</button></form>\n";
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
