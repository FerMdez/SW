<!DOCTYPE HTML>
<?php
    //General Config File:
    require_once('../assets/php/config.php');

    //List of the tittles and descriptions of the movies:
    require_once($prefix.'assets/php/common/film_dao.php');
    $loadFilms = new Film_DAO("complucine");
    $films = $loadFilms->allFilmData();
    $titles = array();
    $descriptions = array();
    $times = array();
    foreach($films as $key => $value){
        $titles[$key] = $value->getTittle();
        $descriptions[$key] = $value->getDescription();
        $times[$key] = $value->getDuration();
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

        <!-- Films -->
        <section id="films_billboard">
            <div class='row'>
            <?php
            for($i = 0; $i < count($films); $i++){
                $title = str_replace('_', ' ', $titles[$i]);
                if($i%2 === 0){
                    if($i != 0) echo "</div>
                ";
                    echo "<div class='column side'>
                    ";
                }
                else{
                    if($i != 0) echo "</div>
                ";
                    echo "<div class='column middle'>
                    ";
                }
                echo "<section id='".$titles[$i]."'>
                        <div class='zoom'>
                            <div class='code showtimes'>
                                <div class='image'><img src='".$prefix."img/".$titles[$i].".jpg' alt='".$titles[$i]."' /></div>
                                <h2>".$title."</h2>
                                <hr />
                                <div class='blockquote'>
                                    <p>".$descriptions[$i]."</p>
                                </div>
                                <p>Duración: ".$times[$i]." minutos</p>
                            </div>
                        </div>
                    </section>
                ";
            }
            echo "</div>\n";
            ?>
            </div>
        </section>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>
       
    </body>

</html>
