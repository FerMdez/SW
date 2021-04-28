<!DOCTYPE HTML>
<?php
    //General Config File:
    require_once(__DIR__.'/assets/php/config.php');

    //List of the tittles of the movies:
    require_once($prefix.'assets/php/common/film_dao.php');
    $films = new Film_DAO("complucine");
    $films_array = $films->allFilmData();
    $tittles = array();
    foreach($films_array as $key => $value){
        $tittles[$key] = $value->getTittle();
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
                        for($i = count($tittles)-4; $i < count($tittles); $i++){
                            if($count%2===0){
                                if($count != 0) echo "</div>
                            ";
                                echo "<div class='fila'>
                            ";
                            }
                            echo "<div class='zoom'>
                                <div class='columna'>
                                    <a href='".$prefix."showtimes/#".$tittles[$i]."'><div class='image'><img src='img/".$tittles[$i].".jpg' alt='".$tittles[$i]."' /></div></a>
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
                        $count = rand(0, count($tittles)-1);
                        $title = str_replace('_', ' ', $tittles[$count]); 
                        echo "<h1>{$title}</h1><hr />
                            <div class='zoom'>
                                <a href='".$prefix."showtimes/#".$tittles[$count]."'><div class='image main'><img src='img/".$tittles[$count].".jpg' alt='".$tittles[$count]."' /></div></a>
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
