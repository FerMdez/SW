<!DOCTYPE HTML>
<?php 
    //General Config File:
    require_once('../../assets/php/config.php');    
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

        <!-- Flow -->
        <section id="flow">
            <div class="code">
                <h2>FLUJO DE NAVEGACIÓN</h2>
                <hr>
                <!-- User Flow -->
                <div class="textbox">
                    <h2>Usuario</h2>
                    <p>
                        El Usuario puede tomar dos caminos a la hora de seleccionar la película, el cine, y la sesión a la que quiere asistir. La diferencia es puramente
                        de orden entre la elección de cine y de la película, a conveniencia del usuario; se procede a explicar ambos:
                    </p>
                    <p>
                        1. Selección de Cine -> Selección de Película -> Selección de Sesión -> Reserva de Butacas -> Checkout: Primero se selecciona el cine en la vista de selección
                        de cines en la que se encuentra un mapa y una lista con los cines de la cadena. Una vez seleccionado el cine se redirigirá al usuario a la vista de selección
                        de película, con el filtro del cine correspondiente activado, de forma que solo se muestren las películas disponibles en el cine seleccionado. En esa vista se
                        eligirá la película y la versión a ver (VO, 3D, 4DX, etc).
                    </p>
                    <p>
                        Una vez elegida la película, se redirigirá al usuario a la elección de sesión. Se mostrarán todas las sesiones disponibles y el usuario podrá elegir la sesión y
                        el número de entradas que quiere reservar, pudiendo ver el precio final de las mismas. Se le llevará a la vista de butacas en donde podrá elegir qué butacas reservar.
                    </p>
                    <p>
                        Una vez elegidas las butacas, el usuario procede a la página de pago, en donde rellenará los datos necesarios para pagar online. Terminada la compra con éxito, se
                        mostrará una pantalla de "Compra Realizada", dando al usuario la seguridad de que su reserva se ha registrado correctamente. Luego se le redirigirá a la pantalla de
                        inicio.
                    </p>
                    <p>
                        2. Selección de Película -> Selección de Cine -> Selección de Sesión -> Reserva de Butacas -> Checkout: Es idéntico al flujo anterior pero el usuario empieza eligiendo
                        la película, de forma que se le redirige a la vista de selección de cine, esta vez con un filtro, de forma que solo se muestran los cines que tengan sesiones activas
                        con la película seleccionada.
                    </p>
                    <p>
                        Una vez elegidos película y cine, el flujo es idéntico al anterior.
                    </p>
                </div>
                <!-- Manager Flow -->
                <div class="textbox">
                    <h2>Gerente</h2>
                    <p>
                        El Gerente es el encargado de gestionar las sesiones y salas de cada cine. La forma de proceder es la misma que el administrador, con vistas equivalentes.
                        En el caso de la gestión de salas, se administrarán los asientos disponibles (por temas de Covid-19) y si está o no habilitada para su uso.
                    </p>
                </div>
                <!-- Admin Flow -->
                <div class="textbox">
                    <h2>Administrador</h2>
                    <p>El Administrador es el encargado de gestionar las: películas, cines, promociones, otros administradores y gerentes de cada cine.</p>
                    <p>Para cada categoría tiene un panel en el que puede seleccionar, a partir de una lista, el elemento que quiere modificar, también hay otro panel al lado, en donde
                    puede modificar los datos de un elemento ya existente o crear uno nuevo introduciendo datos que no existan en la BD. También hay una opción de Eliminar en caso de que
                    quiera eliminar un elemento.</p>
                    <p>También cuenta con un botón de "Vista de Usuario", con el que puede navegar por la página con la vista que tendrá el usuario final.</p>
                </div>
            </div>
        </section>

        <!-- Sketches -->
        <section id="sketches">
            <hr />
            <!-- template Sketches-->
            <div class="code">
                <h3>Pantallas Genéricas</h3>
            </div> 
            <div class="row">
                <div class="column left">
                    <div class="sketches">
                        <img src="../../img/inicio.png" />
                        <div class="description">
                            <h3>Pantalla de inicio</h3>
                            <p>Pantalla de bienvenida al entrar en la web.</p>
                        </div>
                    </div>
                </div>
                <div class="column right">
                    <div class="sketches">
                        <img src="../../img/registrarse_iniciar_sesion.png" />
                        <div class="description">
                            <h3>Pantalla de Registro / Inicio de sesión</h3>
                            <p>Pantalla para que un usuario nuevo se registre o, en caso de ya tener una cuenta de usuario, inicie sesión.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column left">
                    <div class="sketches">
                        <img src="../../img/menu_usuario.png" />
                        <div class="description">
                            <h3>Menú de usuario registrado</h3>
                            <p>Pantalla con todas las opciones disponibles, propias de un usuario registrado.</p>
                        </div>
                    </div>
                </div>
                <div class="column right">
                    <div class="sketches">
                        <img src="../../img/peliculas.png" />
                        <div class="description">
                            <h3>Cartelera</h3>
                            <p>Pantalla con información sobre todas las películas disponibles en ese momento.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column left">
                    <div class="sketches">
                        <img src="../../img/cine.png" />
                        <div class="description">
                            <h3>Cines</h3>
                            <p>Pantalla con un mapa que indica la geolocalización de todos los cines de FDI-Cines.</p>
                        </div>
                    </div>
                </div>
                <div class="column right">
                    <div class="sketches">
                        <img src="../../img/selector_horario.png" />
                        <div class="description">
                            <h3>Selección de Horario</h3>
                            <p>Pantalla que muestra los horarios disponibles por salas para un cine y película elegidos.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column left">
                    <div class="sketches">
                        <img src="../../img/mapa_asientos.png" />
                        <div class="description">
                            <h3>Mapa de los Asientos</h3>
                            <p>Pantalla con un mapa para selccionar los asientos que se quieren escoger. Los asientos ocupados no pondrán ser seleccionados.</p>
                        </div>
                    </div>
                </div>
                <div class="column right">
                    <div class="sketches">
                        <img src="../../img/pagar.png" />
                        <div class="description">
                            <h3>Pagar</h3>
                            <p>Pantalla para realizar el pago, después de haber selecionado película, cine, sala, horario y butacas.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column left">
                    <div class="sketches">
                        <img src="../../img/compra_realizada.png" />
                        <div class="description">
                            <h3>Compra Realizada</h3>
                            <p>Pantalla de confirmación con los datos de compra.</p>
                        </div>
                    </div>
                </div>
                <div class="column right">
                    <div class="sketches">
                        <img src="../../img/about_us.png" />
                        <div class="description">
                            <h3>Sobre nosotros</h3>
                            <p>Pantalla con información sobre FDI-Cines.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column left">
                    <div class="sketches">
                        <img src="../../img/contacto.png" />
                        <div class="description">
                            <h3>Formulario de Contacto</h3>
                            <p>Pantalla con un formulario para realizar una consulta a los administradores.</p>
                        </div>
                    </div>
                </div>
                <div class="column right">
                    <div class="sketches">
                        <img src="../../img/terminos_y_condiciones.png" />
                        <div class="description">
                            <h3>Términos y Condiciones</h3>
                            <p>Pantalla con todos los términos y condiciones de uso del servicio.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manager Sketches-->
            <div class="code">
                <h3>Pantallas de Gerentes</h3>
            </div> 
            <div class="row">
                <div class="column side">
                    <div class="sketches">
                        <img src="../../img/panel_inicio_gerente.png" />
                        <div class="description">
                            <h3>Panel de Incio Gerente</h3>
                            <p>Pantalla con las funciones exclusivas a las que puede acceder un Gerente.</p>
                        </div>
                    </div>
                </div>
                <div class="column middle">
                    <div class="sketches">
                        <img src="../../img/gestionar_salas.png" />
                        <div class="description">
                            <h3>Gestionar salas</h3>
                            <p>Pantalla en la que los Gerentes pueden interactuar para añadir, modificar o eliminar la sala de un cine.</p>
                        </div>
                    </div>
                </div>
                <div class="column side">
                    <div class="sketches">
                        <img src="../../img/gestionar_sesiones.png" />
                        <div class="description">
                            <h3>Gestionar Sesiones</h3>
                            <p>Pantalla en la que los Gerentes pueden interactuar para añadir, modificar o eliminar las sesiones de una película.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Sketches-->
            <div class="code">
                <h3>Pantallas de Administradores</h3>
            </div> 
            <div class="row">
                <div class="column left">
                    <div class="sketches">
                        <img src="../../img/panel_inicio_admin.png" />
                        <div class="description">
                            <h3>Panel Inicio Administrador</h3>
                            <p>Pantalla con las funciones exclusivas a las que puede acceder un Administrador.</p>
                        </div>
                    </div>
                </div>
                <div class="column right">
                    <div class="sketches">
                        <img src="../../img/gestionar_peliculas.png" />
                        <div class="description">
                            <h3>Gestionar Películas</h3>
                            <p>Pantalla en la que los Administradores pueden interactuar para añadir, modificar o eliminar las películas de la cartelera.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column side">
                    <div class="sketches">
                        <img src="../../img/gestionar_cines.png" />
                        <div class="description">
                            <h3>Gestionar Cines</h3>
                            <p>Pantalla en la que los Administradores pueden interactuar para añadir, modificar o eliminar los cines.</p>
                        </div>
                    </div>
                </div>
                <div class="column middle">
                    <div class="sketches">
                        <img src="../../img/gestionar_promociones.png" />
                        <div class="description">
                            <h3>Gestionar Promociones</h3>
                            <p>Pantalla en la que los Administradores pueden interactuar para añadir, modificar o eliminar las promociones existentes.</p>
                        </div>
                    </div>
                </div>
                <div class="column side">
                    <div class="sketches">
                        <img src="../../img/gestionar_admins_gerentes.png" />
                        <div class="description">
                            <h3>Gestionar Administradores y Gerentes</h3>
                            <p>Pantalla en la que los Administradores pueden interactuar para añadir, modificar o eliminar tanto otros Administradores como Gerentes.</p>
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
