<!DOCTYPE HTML>
<?php 
    //General Config File:
    require_once('../assets/php/config.php');

    //Controller file:
    include_once('panelUser.php');

    if($_SESSION["login"] && $_SESSION["rol"] === "user"){
        switch($_GET["option"]){
            case "manage_profile":
                $reply = UserPanel::manage();
                break;
            case "purchases":
                $reply = UserPanel::purchases();
                break;
            case "payment": 
                $reply = UserPanel::payment();
                break;
            case "delete_user"; 
                $reply = UserPanel::delete();
                break;
            default:  
                $reply = UserPanel::panel();
                break;
        }
    }
    else{
        $reply = '<div class="column side"></div>
                    <div class="column middle">
                        <div class="code info">
                            <h1>Debes iniciar sesión para ver tu Panel de Usuario.</h1><hr />
                            <p>Inicia Sesión si estás registrado.</p>
                            <a href="'.$prefix.'login/"><button>Iniciar Sesión</button></a>
                            <p>Registrate si no lo habías hecho previamente.</p>
                            <form method="post" action="'.$prefix.'login/"><button name="register" id="register">Registro</button></form>
                        </div>
                    </div>
                    <div class="column side"></div>'."\n";
    }
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

        <!-- Panel -->
        <div class="row">
            <!-- Panel Menu -->
            <?php
                $template->print_panelMenu($_SESSION["rol"]);
            ?>
            <!-- Contents -->
            <div class="row">
                <?php
                    echo $reply;
                ?>
            </div>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
       
    </body>

</html>
