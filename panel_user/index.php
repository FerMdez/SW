<?php 
    //General Config File:
    require_once('../assets/php/config.php');

    //Controller file:
    include_once('panelUser.php');

    if($_SESSION["login"] && $_SESSION["rol"] === "user"){
        if(!isset($_GET["option"])) $_GET["option"] = null;
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

    
    //Specific page content:
    $section = '<!-- User Panel -->
        <section id="user_panel">
            <div class="row">
                <!-- Contents -->
                <div class="row">
                    '.$reply.'
                </div>
            </div>
        </section>
        ';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
    
?>

