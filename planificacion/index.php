<!DOCTYPE HTML>
<!--
    Práctica 2 - Sistemas Web | Grupo D
    CompluCine - FDI-cines
-->
<html lang="es">
    <head>
        <title>CompluCine | Planificación</title>
        <meta charset="utf-8" />
        <link id="estilo" rel="stylesheet" type="text/css" href="../assets/css/main.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../img/favicon.png" />
    </head>
    <body>
        <!-- Header -->
        <?php
            require_once('../assets/php/header.php');
        ?>

        <!-- Main -->
        <div class="main">
            <div class="image"><img src="../img/logo_trasparente.png" /></div>
            <h1>Planificación*</h1>
            <hr />
        </div>
        
        <!-- Planning -->
        <section class="planning">
            <div class="row">
                <div class="column side">
                    <div class="code plan">
                        <h2>Tareas</h2>
                        <hr />
                        <fieldset>
                            <legend>Implementaciones Generales de la Web</legend>
                            <ul>
                                <li>Pantalla de Inicio (incluye promociones y estrenos) [Fer && Adrián]</li>
                                <li>Cartelera Dinámica [Fer --> Marian && Daniel]</li>
                                <li>Selección Cines (mapa) [Fer]</li>
                                <li>Listado de Horarios [Fer]</li>
                                <li>Selección de butacas [Fer --> Marco && Óscar]</li>
                                <li>Pagar + opción para código promocional [Fer]</li>
                                <li>Sobre FDI-Cines (About us) [Fer && Adrián]</li>
                                <li>Formulario de Contacto [Fer]</li>
                                <li>Términos y Condiciones [Fer && Adrián]</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Paneles de Usuario Registrado</legend>
                            <ul>
                                <li>Registrarse e Iniciar sesión [Adrián]</li>
                                <li>Menú y panel de Usuario (Historial compras, cambiar contraseña, datos de pago y eliminar usuario) [Adrián]</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Paneles de Gerente</legend>
                            <ul>
                                <li>Pantalla de inicio de gerente [Marco && Óscar]</li>
                                <li>Eliminar sesión de una película [Marco && Óscar]</li>
                                <li>Deshabilitar salas [Marco && Óscar]</li>
                                <li>Deshabilitar asientos en una sala [Marco && Óscar]</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Paneles de Administrador</legend>
                            <ul>
                                <li>Panel de inicio administrador (ver todas la funcionalidades de admin de un vistazo) [Daniel && Marian]</li>
                                <li>Ver como >> Usuario no registrado || Usuario registrado || (Gerente: Añadir si vamos bien de tiempo) [Daniel && Marian]</li>
                                <li>Panel añadir/editar/eliminar cine [Marian && Daniel]</li>
                                <li>Panel añadir/editar/eliminar películas a la cartelera [Marian && Daniel]</li>
                                <li>Panel añadir/editar/eliminar promociones [Marian && Daniel]</li>
                                <li>Panel añadir/editar/eliminar gerentes [Marian && Daniel]</li>
                            </ul>
                        </fieldset>
                    </div>
                </div>
                <div class="column middle">
                    <div class="code plan">
                        <h2>Divisón del trabajo</h2>
                        <hr />
                        <fieldset>
                            <legend>Marco Expósito Pérez</legend>
                            <ul>
                                <li>Pantalla de inicio de gerente [Gerente]</li>
                                <li>Eliminar sesión de una película [Gerente]</li>
                                <li>Deshabilitar salas [Gerente]</li>
                                <li>Deshabilitar asientos en una sala [Gerente]</li>
                                <li>Selección de butacas [General (de apoyo)]</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Fernando Méndez Torrubiano</legend>
                            <ul>
                                <li>Pantalla de Inicio (incluye promociones y estrenos) [General]</li>
                                <li>Cartelera Dinámica [General]</li>
                                <li>Selección Cines (mapa) [General]</li>
                                <li>Listado de Horarios [General]</li>
                                <li>Selección de butacas [General]</li>
                                <li>Pagar + opción para código promocional [General]</li>
                                <li>Sobre FDI-Cines (About us) [General (de apoyo)]</li>
                                <li>Formulario de Contacto [General]</li>
                                <li>Términos y Condiciones [General (de apoyo)]</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Daniel Muñoz García</legend>
                            <ul>
                                <li>Panel de inicio administrador (ver todas la funcionalidades de admin de un vistazo) [Administrador]</li>
                                <li>Ver como >> Usuario no registrado || Usuario registrado || (Gerente: Añadir si vamos bien de tiempo) [Administrador]</li>
                                <li>Panel añadir/editar/eliminar cine [Administrador]</li>
                                <li>Panel añadir/editar/eliminar películas a la cartelera [Administrador]</li>
                                <li>Panel añadir/editar/eliminar promociones [Administrador]</li>
                                <li>Panel añadir/editar/eliminar gerentes [Administrador]</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Ioan Marian Tulai</legend>
                            <ul>
                                <li>Panel de inicio administrador (ver todas la funcionalidades de admin de un vistazo) [Administrador]</li>
                                <li>Ver como >> Usuario no registrado | Usuario registrado | (Gerente: Añadir si vamos bien de tiempo) [Administrador]</li>
                                <li>Panel añadir/editar/eliminar cine [Administrador]</li>
                                <li>Panel añadir/editar/eliminar películas a la cartelera [Administrador]</li>
                                <li>Panel añadir/editar/eliminar promociones [Administrador]</li>
                                <li>Panel añadir/editar/eliminar gerentes [Administrador]</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Óscar Ruiz de Pedro</legend>
                            <ul>
                                <li>Pantalla de inicio de gerente [Gerente]</li>
                                <li>Eliminar sesión de una película [Gerente]</li>
                                <li>Deshabilitar salas [Gerente]</li>
                                <li>Deshabilitar asientos en una sala [Gerente]</li>
                                <li>Selección de butacas [General (de apoyo)]</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Adrian Real del Noval</legend>
                            <ul>
                                <li>Registrarse e Iniciar sesión [Usuario Registrado]</li>
                                <li>Menú y panel de Usuario (Historial compras, cambiar contraseña, datos de pago y eliminar usuario) [Usuario Registrado]</li>
                                <li>Sobre FDI-Cines (About us) [General]</li>
                                <li>Términos y Condiciones [General]</li>
                                <li>Pantalla de Inicio (incluye promociones y estrenos) [General (de apoyo)]</li>
                            </ul>
                        </fieldset>
                    </div>
                </div>
                <div class="column side">
                    <div class="code plan">
                        <h2>Plazos</h2>
                        <hr />
                        <fieldset>
                            <legend>Práctica 1 [HTML]</legend>
                            <div class="bar">100%</div>
                            <ul>
                                <li>Inicio</li>
                                <li>Detalles</li>
                                <li>Bocetos</li>
                                <li>Miembros</li>
                                <li>Planificación</li>
                                <li>Contacto</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Práctica 2 [HTML + PHP]</legend>
                            <div class="bar">100%</div>
                            <ul>
                                <li>Sobre FDI-Cines (About us) [Fer && Adrián]</li>
                                <li>Formulario de Contacto [Fer]</li>
                                <li>Términos y Condiciones [Fer && Adrián]</li>
                                <li>Pantalla de inicio de gerente [Marco && Óscar]</li>
                            </ul>
                            <div class="bar seventyfive">75%</div>
                            <ul>
                                <li>Pantalla de Inicio (incluye promociones y estrenos) [Fer && Adrián]</li>
                                <li>Listado de Horarios [Fer]</li>
                            </ul>
                            <div class="bar fifty">50%</div>
                            <ul>
                                <li>Menú y panel de Usuario (Historial compras, cambiar contraseña, datos de pago y eliminar usuario) [Adrián]</li>
                                <li>Eliminar sesión de una película [Marco && Óscar]</li>
                                <li>Deshabilitar salas [Marco && Óscar]</li>
                                <li>Panel de inicio administrador (ver todas la funcionalidades de admin de un vistazo) [Daniel && Marian]</li>
                                <li>Panel añadir/editar/eliminar cine [Marian && Dani]</li>
                                <li>Panel añadir/editar/eliminar películas a la cartelera [Marian && Dani]</li>
                            </ul>
                            <div class="bar twentyfive">25%</div>
                            <ul>
                                <li>Registrarse && Iniciar sesión [Adrián]</li>
                                <li>Deshabilitar asientos en una sala [Marco && Óscar]</li>
                                <li>Ver como >> Usuario no registrado | Usuario registrado | (Gerente: Añadir si vamos bien de tiempo) [Daniel && Marian]</li>
                                <li>Panel añadir/editar/eliminar promociones [Marian && Dani]</li>
                                <li>Panel añadir/editar/eliminar gerentes [Marian && Dani]</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Práctica 3 [HTML + PHP + CSS]</legend>
                            <div class="bar">100%</div>
                            <ul>
                                <li>Eliminar sesión de una película [Marco && Óscar]</li>
                                <li>Deshabilitar salas [Marco && Óscar]</li>
                            </ul>
                            <div class="bar seventyfive">75%</div>
                            <ul>
                                <li>Registrarse && Iniciar sesión [Adrián]</li>
                                <li>Menú y panel de Usuario (Historial compras, cambiar contraseña, datos de pago y eliminar usuario) [Adrián]</li>
                                <li>Panel de inicio administrador (ver todas la funcionalidades de admin de un vistazo) [Daniel && Marian]</li>
                                <li>Panel añadir/editar/eliminar cine [Marian && Dani]</li>
                                <li>Panel añadir/editar/eliminar películas a la cartelera [Marian && Dani]</li>
                            </ul>
                            <div class="bar fifty">50%</div>
                            <ul>
                                <li>Deshabilitar asientos en una sala [Marco && Óscar]</li>
                                <li>Ver como >> Usuario no registrado | Usuario registrado | (Gerente: Añadir si vamos bien de tiempo) [Daniel && Marian]</li>
                                <li>Panel añadir/editar/eliminar promociones [Marian && Dani]</li>
                                <li>Panel añadir/editar/eliminar gerentes [Marian && Dani]</li>
                            </ul>
                        </fieldset>
                        <fieldset>
                            <legend>Entrega Final [HTML + PHP + CSS + JS]</legend>
                            <div class="bar">100%</div>
                            <ul>
                                <li>Todo el trabajo restante.</li>
                            </ul>
                        </fieldset>
                    </div>
                </div>
            </div>
        </section>

        <!-- Timeline -->
        <section id="timeline" class="timeline">
            <h2>Línea Temporal</h2>
            <hr />
            <div class="image"><img src="../img/linea_temporal.png" /></div>
        </section>

        <!-- Timeline Table -->
        <section id="timeline table">
            <h2>Hitos</h2>
            <hr />
            <table>
                <thead>
                    <tr>
                        <th>Hito</th>
                        <th>Fecha estimada</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Práctica 0</td>
                        <td>4 de Marzo de 2021</td>
                        <td>ENTREGADO</td>
                    </tr>
                    <tr>
                        <td>Práctica 1</td>
                        <td>18 de Marzo de 2021</td>
                        <td>ENTREGADO</td>
                    </tr>
                    <tr>
                        <td>Práctica 2</td>
                        <td>15 de Abril de 2021</td>
                        <td>EN PROCESO</td>
                    </tr>
                    <tr>
                        <td>Práctica 3</td>
                        <td>7 de Mayo de 2021</td>
                        <td>PENDIENTE</td>
                    </tr>
                    <tr>
                        <td>Entrega Final</td>
                        <td>28 de Mayo de 2021</td>
                        <td>PENDIENTE</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Warning -->
        <section id="warning">
            <p>
                *Esta planificación es orientativa y puede ir cambiando a lo largo del tiempo 
                en función de los requisitos de las prácticas y nuestra carga de trabajo.
            </p>
        </section>

        <!-- Footer -->
        <?php
            include_once('../assets/php/footer.php');
        ?>
       
    </body>

</html>