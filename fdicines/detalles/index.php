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

        <!-- Details -->
		<section id="details">
			<div class = "code">
				<h1>Detalles</h1>
				<hr/>
				<div class ="blockquote">
					<p>
						Con este proyecto buscamos la creación de una aplicación web que
						gestione la cartelera de un grupo de cines con una cartelera de películas variable, unos horarios propios de cada cine por sesión y película
						y unos precios determinados.
					</br>
						Los usuarios podrán registrarse, comprar sus entradas para una
						sesión, elegir asientos, precomprar sus snacks y ver ofertas y promociones.
					</p>
				</div>
			</div>
		</section>
		<!-- User and Functionalities -->
		<section id="user_functionalities">
			<div class ="row">
				<div class="column left">
					<div class = "code details">
						<h2>Tipos de usuario</h2>
						<hr />	
						<div class="textbox">
							<h2>Usuario No Registrado</h2>
							<p>
								Este tipo de usuario, puede interactuar con la web sin necesidad de estar registrado. Podrá realizar compras, ver horarios y cartelera, sin necesidad de realizar ningún registro.
								No podrá usar ninguna de las promociones, pues estas estarán únicamente destinadas a los usuarios registrados.
							</p>
						</div>
						<div class="textbox">
							<h2>Usuario Registrado</h2>
							<p>
								Estos usuarios son aquellos que previamente han realizado un registro en la base de datos del sistema. Tendrán las mismas funcionalidades básicas 
								que un usuario no registrado y además, podrán acceder a ofertas y aplicar promociones y descuentos y ver el historial de sus compras.
								Además, estos usuarios podrán cancelar una compra previamente hecha, pues estas se asociarían a su cuenta, algo que sería imposible
								con un usuario no registrado.
							</p>
						</div>
						<div class="textbox">
							<h2>Gerente de Cine</h2>
							<p>
								Un administrador de rango bajo capaz de acceder a la vista de administradores, puede ver las peliculas que hay en la base de datos. 
								Este usuario está asociado a un cine, sobre el cual puede añadir sesiones con peliculas existentes y modificar la disposicion de butacas.
							</p>
						</div>
						<div class="textbox">
						<h2>Administrador</h2>
							<p>
								El administrador es capaz de ascender cuentas de usuario registradas a cuentas de gerente de cine. Ademas es el encargado de añadir nuevos cines y peliculas.
								Para comprobar el correcto funcionamiento de la pagina podrá cambiar entre distintas vistas de usuario. 
								Las cuales le permitirán comprobar que cada usuario tiene acceso únicamente a sus funcionalidades y no a funcionalidades de otro rango superior.
							</p>
						</div>
					</div>
				</div>
				<div class="column right">
					<div class = "code details">
						<h1>Funcionalidad</h1>
						<hr />
						<p>
							La aplicación debe permitir la compra online de entradas para sesiones de cine, mostrando los cines y
							horarios en los que se encuentra disponible la película seleccionada por el usuario dentro del catálogo disponible en ese momento (la cartelera).
							Los usuarios podrán acceder a la compra de entradas buscando la película que desean ver y luego escogiendo un cine y horario determinado. 
							Además de una búsqueda específica, también se ofrecerá la posibilidad de visionar toda la cartelera, y escoger una película, horario y cine, de entre todas las posibilidades.
						<p>
							Una vez escogido todo, se mostrará una página en la que el usuario decidirá la o las butacas en las que se sentará. Se mostrarán butacas disponibles y butacas ocupadas (en caso de que las haya).
							Antes de realizar la compra, los usuarios podrán aplicar promociones especificas que le permitan obtener algun snack en el cine o descuentos disponibles en la aplicación.
						</p>
						<p>
							Por otro lado la aplicacion debe permitir a los gerentes y administradores visionar la lista y contenido de todas las peliculas que hay en cartelera, 
							siendo los administradores los encargados de modificarlas y añadir nuevas.
							De igual forma, ambos podran ver todos los cines activos de la aplicacion, pero solo los administradores serán capaces de añadir o modificar cines existentes.
						<p>
							Cada cine tiene una cantidad de salas y sesiones con horarios específicos pora cada una de las películas. 
							Aunque ambos roles (administrador y gerente) pueden ver estas salas y horarios, es el gerente de cine el encargado de modificar las salas, 
							su disposición de butacas, modificar el horario de las sesiones y añadir nuevas sesiones, y crear promociones específicas para una sesión concreta o para el cine completo. 
							Todo esto unicamente para el cine con el cual esta relacionado.
						</p>
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
