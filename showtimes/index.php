<!DOCTYPE HTML>
<?php 
    session_start();

    //HTML template:
    require_once('../assets/php/template.php');
    $template = new Template();
    $prefix = $template->get_prefix();

    //List of the tittles and descriptions of the movies:
    require_once('includes/loadFilms.php');
    $loadFilms = new loadFilms();
    $films = $loadFilms->getFilms();
    $descriptions = $loadFilms->getDescription();
    
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
                $title = str_replace('_', ' ', $films[$i]);
                $description = $descriptions[$i];
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
                echo "<section id='".$films[$i]."'>
                        <div class='zoom'>
                            <div class='code showtimes'>
                                <div class='image'><img src='".$prefix."img/".$films[$i].".jpg' alt='".$films[$i]."' /></div>
                                <h2>".$title."</h2>
                                <hr />
                                <div class='blockquote'>
                                    <p>".$description."</p>
                                </div>
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
