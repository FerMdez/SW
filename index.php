<!DOCTYPE HTML>
<?php
    session_start();
    // BORRAR CUANDO TENGAMOS BBDD:
    $films = array(
        "iron_man",
        "iron_man_2",
        "iron_man_3",
        "capitan_america_el_primer_vengador",
        "capitan_america_el_soldado_de_invierno",
        "capitan_america_civil_war",
        "marvel_avengers",
        "avengers_age_of_ultron",
        "avengers_inifinity_war",
        "avengers_end_game"
    );

    require_once('./assets/php/template.php');
    $template = new Template();
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
            <div class="image"><a href='./'><img src="./img/logo_trasparente.png" alt="logo_FDI-Cines" /></a></div>
            <?php
                if(isset($_SESSION["nombre"])){
                    echo "<h1>Bienvenido {$_SESSION["nombre"]}</h1>\n";
                }
                else{
                    echo "<h1>Bienvenido a CompluCine</h1>\n";
                }
            ?>
            <hr />
        </div>
        
        <!-- Undercard -->
        <section id="cartelera">
            <div class="row">
                <div class="code">
                    <div class="column left">
                        <div class="galery">
                        <h1>Últimos Estrenos</h1><hr />
                        <?php
                        $count = 0;
                        for($i = count($films)-4; $i < count($films); $i++){
                            if($count%2===0){
                                if($count != 0) echo "</div>
                            ";
                                echo "<div class='fila'>
                            ";
                            }
                            echo "<div class='zoom'>
                                <div class='columna'>
                                    <a href='".$prefix."showtimes/#".$films[$i]."'><div class='image'><img src='img/".$films[$i].".jpg' alt='".$films[$i]."' /></div></a>
                                </div>
                            </div>
                            ";
                            $count++;
                        }
                        echo "</div>\n";
                        ?>
                        </div>
                    </div>
                    <div class="column right">
                        <div class="galery">
                        <?php
                        $count = rand(0, count($films)-1);
                        $title = str_replace('_', ' ', $films[$count]); 
                        echo "<h1>{$title}</h1><hr />
                            <div class='zoom'>
                                <a href='".$prefix."showtimes/#".$films[$count]."'><div class='image main'><img src='img/".$films[$count].".jpg' alt='".$films[$count]."' /></div></a>
                            </div>\n";
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
    </body>

</html>
