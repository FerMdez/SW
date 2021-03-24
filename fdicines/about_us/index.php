<!DOCTYPE HTML>
<?php 
    session_start();
    require_once('../../assets/php/template.php');
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
            <div class="image"><a href='../../'><img src="../../img/logo_trasparente.png" alt="logo_FDI-Cines" /></a></div>
			<!-- Sub Header -->
            <?php
                $template->print_subheader();
            ?>
        </div>
        
        <!-- Description -->
        <section id="description">
            <div class="code" id="resume">
                <h1>Descripción</h1>
                <hr />
                <div class="blockquote">  
                    <p>
                        CompluCine es un proyecto para la creación y desarrollo de una plataforma web que permita la compra de entradas
                        de cine, por fecha y hora, para cualquiera de los cines del grupo <a href="#FDI-Cines">FDI-Cines</a> 
                        mostrar la cartelera disponible e incluya ofertas y promociones para los clientes.
                    </p>
                    <p>
                        Con este proyecto buscamos la creación de una aplicación web que
                        gestione la cartelera de un grupo de cines con una lista de películas variable, 
                        unos horarios propios de cada cine por sesión y película, y con unos precios determinados.
                    </p>
                    <p>
                        Los usuarios podrán registrarse, comprar sus entradas para una
                        sesión, elegir asientos, precomprar sus snacks y ver ofertas y promociones.
                    </p>
                </div>
            </div>
            <div class="code" id="FDI-Cines">
                <h2>FDI-Cines</h2>
                <hr />
                <div class="blockquote">
                    <p>
                        Somos un <a href="../../miembros/">grupo de estudiantes</a> de la asignatura de Sistemas Web
                        de la Facultad de Informática de la Universidad Complutense de Madrid.
                    </p>
                    <p>
                        CompluCine es un proyecto web universitario y en ningún momento pretende ofrecer una funcionalidad real.
                        Para más información acerca del proyecto, haz click <a href="../../detalles/">aquí</a>.
                    </p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>

    </body>

</html>