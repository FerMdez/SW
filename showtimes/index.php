<!DOCTYPE HTML>
<?php 
    session_start();

    require_once('../assets/php/template.php');
    $template = new Template();
    $prefix = $template->get_prefix();

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
                            <div class='code'>
                                <div class='image'><img src='".$prefix."img/".$films[$i].".jpg' alt='".$films[$i]."' /></div>
                                <h2>".$title."</h2>
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
