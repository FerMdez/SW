<?php
    class Template {

    //Constants:
    //private const _NUMPAGES = 10; //Constant to page results.

    //Attributes:
    private $page;                  //Page Name.
    private $prefix;                //Page prefix.

    private $session;               //"Iniciar Sesión" (if user isn´t logged in), "Cerrar Sesión" (otherwise).
    private $session_route;         //"login/" (if user isn´t logged in), "logout/" (otherwise).
    private $panel;                 //Button to access the user's dashboard (only displayed if logged in).
    private $user_route;            //Route of the panel (depends on the type of user).
    private $sessionButtonClass;    //Type of button to login or logout.

    //Constructor:
    function __construct(){
        $this->page = $_SERVER['PHP_SELF']; //Page that instantiates the template.
        $this->prefix = '../';              //Default prefix.

        $this->set_page_prefix();           //Assigns the name and prefix of the page.

        $this->session = 'Iniciar Sesión';  //Default, the session has not started.
        $this->session_route = 'login/';    //Default, the session has not started.
        $this->panel = '';                  //Default, the session has not started.
        $this->user_route = 'panel_user/';  //Default, the type of client is user.
        $this->sessionButtonClass = '';     //Default, normal button.
    }

    //Methods:

    //Assigns the name and prefix of the page:
    private function set_page_prefix() {
        switch(true){
            case strpos($this->page, 'panel_user'): $this->page = 'Panel de Usuario'; break;
            case strpos($this->page, 'panel_manager'): $this->page = 'Panel de Gerente'; break;
            case strpos($this->page, 'panel_admin'): $this->page = 'Panel de Administrador'; break;
            case strpos($this->page, 'login'): $this->page = 'Acceso'; break;
            case strpos($this->page, 'logout'): $this->page = 'Cerrar Sesión'; break;
            case strpos($this->page, 'register'): $this->page = 'Registro de Usuario'; break;
            case strpos($this->page, 'showtimes'): $this->page = 'Cartelera'; break;
            case strpos($this->page, 'purchase'): $this->page = 'Comprar Entrada'; break;
            case strpos($this->page, 'promotions'): $this->page = 'Promociones'; break;
            case strpos($this->page, 'cinemas'): $this->page = 'Nuestros Cines'; break;
            case strpos($this->page, 'about_us'): $this->page = 'Sobre FDI-Cines'; $this->prefix = '../../'; break;
            case strpos($this->page, 'terms'): $this->page = 'Términos y Condiciones'; $this->prefix = '../../'; break;
            case strpos($this->page, 'detalles'): $this->page = 'Detalles'; $this->prefix = '../../'; break;
            case strpos($this->page, 'bocetos'): $this->page = 'Bocetos'; $this->prefix = '../../'; break;
            case strpos($this->page, 'miembros'): $this->page = 'Miembros'; $this->prefix = '../../'; break;
            case strpos($this->page, 'planificacion'): $this->page = 'Planificación'; $this->prefix = '../../'; break;
            case strpos($this->page, 'contacto'): $this->page = 'Contacto'; break;
            case strpos($this->page, 'assets'): $this->prefix = '../../../'; break;
            default: $this->page = 'FDI-Cines'; $this->prefix = './'; break;
        }
    }

    //Returns page name:
    function get_page(){
        return $this->page;
    }

    //Returns page prefix:
    function get_prefix(){
        return $this->prefix;
    }

    //Print generic Head:
    function print_head(){
        $page = $this->page;
        $prefix = $this->prefix;

        if(!isset($_SESSION["css"])) $_SESSION["css"] = "main.css";

        $extraCSS = "";
        if($page === "Comprar Entrada") $extraCSS = "\n<link id='estilo' rel='stylesheet' type='text/css' href='{$prefix}assets/css/seat.css'>";
        if($page === "Panel de Gerente") $extraCSS = "<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css' />";

        echo"<head>
        <title>CompluCine | {$page}</title>
        <meta charset='utf-8' />
        <link id='estilo' rel='stylesheet' type='text/css' href='{$prefix}assets/css/{$_SESSION['css']}'>{$extraCSS}
        <noscript><h1>Esta página requiere JavaScript para su correcto funcionamiento. 
            Compruebe si JavaScript está deshabilitado en su navegador.</h1></noscript>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='icon' href='{$prefix}img/favicon.png' />
    </head>\n";
    }

    //Print generic Header:
    function print_header(){
        $page = $this->page;
        $prefix = $this->prefix;
        $session = $this->session;
        $sessionButtonClass = $this->sessionButtonClass;
        $session_route = $this->session_route;
        $user_route = $this->user_route;
        $panel =$this->panel;

        if(isset($_SESSION["rol"])){
            if($_SESSION["rol"] === "admin") $user_route = 'panel_admin/';
            else if($_SESSION["rol"] === "manager") $user_route = 'panel_manager/';
            $panel = "<a href='{$prefix}{$user_route}'><li>Mi Panel</li></a>";
            $session = 'Cerrar Sesión';
            $sessionButtonClass = 'danger';
            $session_route = 'logout/';
        }

        if(isset($_SESSION["lastRol"]) && ($_SESSION["lastRol"] === "admin" || $_SESSION["lastRol"] === "manager" )){
            $changeRol = "<a href='{$prefix}assets/php/common/resetRol.php'><li class='danger'>Volver a {$_SESSION["lastRol"]}</li></a>";
        } else {
            $changeRol = null;
        }
        
        echo"<div class='header'>
            <a href='{$prefix}'><img src='{$prefix}img/favicon2.png' alt='favicon' /> CompluCine</a> | {$page}
            <div class='menu'>
                <nav>{$changeRol}
                    <a href='{$prefix}{$session_route}'><li class={$sessionButtonClass}>{$session}</li></a>
                    {$panel}
                    <li>Menú
                        <ul>
                            <a href='{$prefix}'><li>Inicio</li></a>
                            <a href='{$prefix}showtimes/'><li>Cartelera</li></a>
                            <a href='{$prefix}cinemas/'><li>Nuestros Cines</li></a>
                            <a href='{$prefix}promotions/'><li>Promociones</li></a>
                            <a href='{$prefix}fdicines/miembros/'><li>Quiénes somos</li></a>
                            <a href='{$prefix}contacto/'><li>Contacto</li></a>
                        </ul>
                    </li>
                </nav>
            </div>
        </div>\n";
    }

    //Print generic subHeader:
    function print_subheader(){
        //$page = $this->page;
        $prefix = $this->prefix;

        echo"<div class='header sub'>
            <div class='menu'>
                <nav>
                    <a href='{$prefix}fdicines/about_us/'><li>Sobre FDI-Cines</li></a>
                    <a href='{$prefix}fdicines/detalles/'><li>Detalles</li></a>
                    <a href='{$prefix}fdicines/bocetos/'><li>Bocetos</li></a>
                    <a href='{$prefix}fdicines/miembros/'><li>Miembros</li></a>
                    <a href='{$prefix}fdicines/planificacion/'><li>Planificación</li></a>
                </nav>
            </div>
        </div>\n";
    }

    //Print generic Main:
    function print_main($content = ""){
        $page = $this->page;
        $prefix = $this->prefix;

        /* SubHeader on Main */
        $sub_header = '';
        if(strpos($_SERVER['PHP_SELF'], 'fdicines')){
            $sub_header = "<!-- Sub Header -->
                <div class='header sub'>
                    <div class='menu'>
                        <nav>
                            <a href='{$prefix}fdicines/about_us/'><li>Sobre FDI-Cines</li></a>
                            <a href='{$prefix}fdicines/detalles/'><li>Detalles</li></a>
                            <a href='{$prefix}fdicines/bocetos/'><li>Bocetos</li></a>
                            <a href='{$prefix}fdicines/miembros/'><li>Miembros</li></a>
                            <a href='{$prefix}fdicines/planificacion/'><li>Planificación</li></a>
                        </nav>
                    </div>
                </div>\n"; 
        }

        /* MAIN */
        if($prefix === "./"){ 
            if(isset($_SESSION["nombre"])){
                $tittle = "<h1>Bienvenido {$_SESSION["nombre"]}</h1>\n";
            } else {
                $tittle = "<h1>Bienvenido a CompluCine</h1>\n";
            }
        } else {
            $tittle = "<h1>{$page}</h1>\n";
        }

        echo"<main>
            <div class='image'><a href='{$prefix}'><img src='{$prefix}img/logo_trasparente.png' alt='logo_FDI-Cines' /></a></div>
            {$sub_header}
            {$tittle}{$content}
            <hr />
        </main>\n";
    }

    //Print panel menu:
    function print_panelMenu($panel){
        if($_SESSION["login"]){
            $prefix = $this->prefix;
            $menus = array("<a href='./'><li>Panel Principal</li></a>");

            switch($panel){
                case "admin": array_push($menus, "<li>Ver como...
                                                        <ul>
                                                            <a href='./?state=un'><li>Usuario</li></a>
                                                            <a href='./?state=ur'><li>Usuario registrado</li></a>
                                                            <a href='./?state=ag'><li>Gerente</li></a>
                                                        </ul>
                                                    </li>");
                                array_push($menus, "<li>Modificar
                                                        <ul>
                                                            <a href='./?state=mc'><li>Cines</li></a>
                                                            <a href='./?state=mf'><li>Películas</li></a>
                                                            <a href='./?state=mp'><li>Promociones</li></a>
                                                            <a href='./?state=mg'><li>Gerentes</li></a>
                                                        </ul>
                                                    </li>");
                                break;

                case "manager": array_push($menus, "<li>Ver como...
                                                        <ul>
                                                            <a href='./?state=view_user'><li>Usuario</li></a>
                                                            <a href='./?state=view_ruser'><li>Usuario registrado</li></a>
                                                        </ul>
                                                    </li>");
                                array_push($menus, "<li>Modificar
                                                        <ul>
                                                            <a href='./?state=manage_halls'><li>Salas</li></a>
                                                            <a href='./?state=manage_sessions'><li>Sesiones</li></a>
                                                        </ul>
                                                    </li>");
                                break;

                case "user": array_push($menus, "<a href='./?option=purchases'><li>Historial Compras</li></a>");
                                //array_push($menus, "<a href='./?option=payment'><li>Datos Pago</li></a>");
                                    array_push($menus, "<a href='./?option=delete_user'><li>Eliminar Usuario</li></a>");
                                        break;

                default: $menus = array(); break;
            }

            if($_SESSION["rol"] === $panel){
                echo"<div class='header sub'>
                <div class='menu'>
                    <nav>";
                    foreach($menus as $value){
                        echo $value;
                    }  
                    echo"</nav>
                </div>
            </div>
        ";
            }
        }
    }

    //Print specific page content:
    function print_section($section){
        /* Panel menu */
        $sub_header = '';
        if(strpos($_SERVER['PHP_SELF'], 'panel')){
            echo "<!-- Panel Menu -->
            ";
            $this->print_panelMenu($_SESSION["rol"]);
            $this->print_msg();
        }

        echo $section;
    }

    //Print Films Cards:
    function print_fimls(){
        $reply = "";
        //List of the movies:
        require_once(__DIR__.'/includes/film_dao.php');

        $prefix= $this->get_prefix();

        $films = new Film_DAO("complucine");
        $films_array = $films->allFilmData();
        $ids = array();
        $tittles = array();
        $descriptions = array();
        $times = array();
        $languages = array();
        $images = array();
        if(is_array($films_array)){
            foreach($films_array as $key => $value){
                $ids[$key] = $value->getId();
                $tittles[$key] = $value->getTittle();
                $descriptions[$key] = $value->getDescription();
                $times[$key] = $value->getDuration();
                $languages[$key] = $value->getLanguage();
                $images[$key] = $value->getImg();
            }
        }
        switch($this->page){
            case "Cartelera": 
                if(is_array($films_array)){
                for($i = 0; $i < count($films_array); $i++){
                    $tittle = str_replace('_', ' ', $tittles[$i]);
                    if($i%2 === 0){
                        if($i != 0) $reply .= "</div>
                    ";
                        $reply .= "<div class='column side'>
                        ";
                    }
                    else{
                        if($i != 0) $reply .= "</div>
                    ";
                    $reply .= "<div class='column middle'>
                        ";
                    }
                    $reply .= "<section id='".$tittles[$i]."'>
                            <div class='zoom'>
                                <a href='".$prefix."purchase?film=".$ids[$i]."'>
                                <div class='code showtimes'>
                                    <div class='image'><img src='".$prefix."img/films/".$images[$i]."' alt='".$tittles[$i]."' /></div>
                                    <h2>".$tittle."</h2>
                                    <hr />
                                    <div class='blockquote'>
                                        <p>".$descriptions[$i]."</p>
                                    </div>
                                    <li>Duración: ".$times[$i]." minutos</li>
                                    <li>Lenguaje: ".$languages[$i]."</li>
                                </div>
                                </a>
                            </div>
                        </section>
                    ";
                }
                }
                $reply .= "</div>\n";
                break;

            case "Panel de Administrador":
                $reply .= "<div class='column'>";
                if(is_array($films_array)){
                for($i = 0; $i < count($films_array); $i++){
                    $tittle = str_replace('_', ' ', $tittles[$i]);
                    if($i%2 === 0){
                        if($i != 0) $reply .= "</div>
                    ";
                        $reply .= "<div class='column side'>
                        ";
                    }
                    else{
                        if($i != 0) $reply .= "</div>
                    ";
                        $reply .= "<div class='column middle'>
                        ";
                    }
                    $reply .= "<section id='".$tittles[$i]."'>
                            <div class='zoom'>
                                <div class='code showtimes'>
                                    <div class='image'><img src='".$prefix."img/films/".$images[$i]."' alt='".$tittles[$i]."' /></div>
                                    <h2>".$tittle."</h2>
                                    <hr />
                                    <form method='post' action='./index.php?state=mf'>
                                        <input name='id' type='hidden' value='".$ids[$i]."'>
                                        <input name='tittle' type='hidden' value='".$tittles[$i]."'>
                                        <input  name='duration' type='hidden' value='".$times[$i]."'>
                                        <input  name='language' type='hidden' value='".$languages[$i]."'>
                                        <input name='description' type='hidden' value='".$descriptions[$i]."'>
                                        <input type='submit' id='submit' value='Editar' name='edit_film' class='primary' />
                                    </form>
                                    <form method='post' action='./index.php?state=mf'>
                                        <input name='id' type='hidden' value='".$ids[$i]."'>
                                        <input name='tittle' type='hidden' value='".$tittles[$i]."'>
                                        <input  name='duration' type='hidden' value='".$times[$i]."'>
                                        <input  name='language' type='hidden' value='".$languages[$i]."'>
                                        <input name='description' type='hidden' value='".$descriptions[$i]."'>
                                        <input type='submit' id='submit' value='Eliminar' name='delete_film' class='primary' />
                                    </form>
                                </div>
                            </div>
                        </section>
                    ";
                }
                }
                $reply .= "</div>\n";                
                break;
				
			case "Panel de Gerente":
                $reply .= "<div class='column'>";
                if(is_array($films_array)){
                for($i = 0; $i < count($films_array); $i++){
                    $tittle = str_replace('_', ' ', $tittles[$i]);
                    if($i%2 === 0){
                        if($i != 0) $reply .= "</div>
                    ";
                        $reply .= "<div class='column side'>
                        ";
                    }
                    else{
                        if($i != 0) $reply .= "</div>
                    ";
                        $reply .= "<div class='column middle'>
                        ";
                    }
                    $reply .= "<section id='".$tittles[$i]."'>
                            <div class='zoom'>
                                <div class='code showtimes'>
                                    <div class='image'><img src='".$prefix."img/films/".$images[$i]."' alt='".$tittles[$i]."' /></div>
                                    <h2>".$tittle."</h2>
                                    <hr />
                                    <li>Duración: ".$times[$i]." minutos</li>
                                    <li>Lenguaje: ".$languages[$i]."</li>
                                
								<form method='post' action='./?state=".$_SESSION["option"]."'>
									<input name='film' type='hidden' value='".$ids[$i]."'>
									<input name='tittle' type='hidden' value='".$tittles[$i]."'>
									<input name='duration' type='hidden' value='".$times[$i]."'>
									<input name='language' type='hidden' value='".$languages[$i]."'>
									<input name='description' type='hidden' value='".$descriptions[$i]."'>
									<input name='hall' type='hidden' value='".$_POST["hall"]."'>
									<input name='date' type='hidden' value='".$_POST["date"]."'>
									<input name='start' type='hidden' value='".$_POST["start"]."'>	
									<input name='price' type='hidden' value='".$_POST["price"]."'>
									<input name='format' type='hidden' value='".$_POST["format"]."'>
									<input name='or_hall' type='hidden' value='".$_POST["or_hall"]."'>
									<input name='or_date' type='hidden' value='".$_POST["or_date"]."'>
									<input name='or_start' type='hidden' value='".$_POST["or_start"]."'>
									<input type='submit' id='submit' value='Seleccionar' name='select_film' class='primary' />
								</form>
								</div>
                            </div>
                        </section>
                    ";
                }
                }
                $reply .= "</div>\n"; 
                break;
				
            default: 
                if(is_array($films_array)){
                    $reply .='<div class="column left">
                         <div class="galery">
                            <h1>Últimos Estrenos</h1><hr />';
                    $count = 0;
                    for($i = count($tittles)-4; $i < count($tittles); $i++){
                        if($count%2===0){
                            if($count != 0) $reply .= "
                            </div>";
                        $reply .= "
                            <div class='fila'>";
                        }
                        $reply .= "
                                <div class='zoom'>
                                    <div class='columna'>
                                        <a href='".$prefix."showtimes/#".$tittles[$i]."'><div class='image'><img src='img/films/".$images[$i]."' alt='".$tittles[$i]."' /></div></a>
                                    </div>
                                </div>";
                        $count++;
                    }
                    $reply .= "
                            </div>
                        </div>
                    </div>
                    <div class='column right'>
                        <div class='galery'>";
                    $count = rand(0, count($tittles)-1);
                    $title = str_replace('_', ' ', $tittles[$count]); 
                    $reply .= "
                            <h1>{$title}</h1><hr />
                            <div class='zoom'>
                                <a href='".$prefix."showtimes/#".$tittles[$count]."'><div class='image main'><img src='img/films/".$images[$count]."' alt='".$tittles[$count]."' /></div></a>
                            </div>
                        </div>
                    </div>\n";
                }
                    break;
        }

        return $reply;
    }

    //Print Cinemas info:
    function print_cinemas(){
        $reply = "";

        //List of the cinemas:
        require_once(__DIR__.'/includes/cinema_dao.php');

        $prefix= $this->get_prefix();

        $cine = new Cinema_DAO("complucine");
        $cinemas = $cine->allCinemaData();
        $ids = array();
        $names = array();
        $directions = array();
        $phones = array();

        if(!is_array($cinemas)){
            $reply = "<h2>No hay cines actualmente</h2>";
        }
        else{
            foreach($cinemas as $key => $value){
                $ids[$key] = $value->getId();
                $names[$key] = $value->getName();
                $directions[$key] = $value->getDirection();
                $phones[$key] = $value->getPhone();
            }
        
        switch($this->page){
            case "Nuestros Cines":

                for($i = 0; $i < count($cinemas); $i++){
                    if($i%2 === 0){
                        if($i != 0) $reply .= "</div>
                    ";
                        $reply .= "<div class='column side'>
                        ";
                    }
                    else{
                        if($i != 0) $reply .= "</div>
                    ";
                    $reply .= "<div class='column middle'>
                        ";
                    }
                    $reply .= "<section id='".$names[$i]."'>
                            <div class='zoom'>
                                <a href='".$prefix."purchase?cinema=".$ids[$i]."'>
                                <div class='code cinemas'>
                                    <h2>".$names[$i]."</h2>
                                    <hr />
                                    <section class='column left'>
                                        <img src='../img/sala1.jpg' alt='".$names[$i]."' />
                                    </section>
                                    <section class='column right'>
                                        <section class='blockquote'>
                                            <li>Dirección: ".$directions[$i]."</li>
                                            <li>Teléfono: ".$phones[$i]."</li>
                                        </section>
                                    </section>
                                </div>
                                </a>
                            </div>
                        </section>
                    ";
                }
                $reply .= "</div>\n";
                break;
            case "Panel de Administrador":
                    $reply .= "<div class='row'>
                            <ul class='tablelist col6'> 
                                <li class='title'>Id</li>
                                <li class='title'>Nombre</li>
                                <li class='title'>Dirección</li>
                                <li class='title'>Teléfono</li>
                                <li class='title'>Editar</li>
                                <li class='title'>Eliminar</li>
                            ";
                        $parity = "odd";
                        for($i = 0; $i < count($cinemas); $i++){
                            $reply .= '
                                    <div class="'.$parity.'">
                                    <a class="h2long" href="index.php?state=mc&cinema='.$ids[$i].'">
                                        <li>'. $ids[$i] .'</li>
                                        <li>'. $names[$i] .'</li>
                                        <li>'. $directions[$i] .'</li>
                                        <li>'. $phones[$i] .'</li>
                                    </a>
                                        <li>
                                            <form method="post" action="index.php?state=mc">
                                                <input  name="id" type="hidden" value="'.$ids[$i].'">
                                                <input  name="name" type="hidden" value="'.$names[$i].'">
                                                <input  name="direction" type="hidden" value="'.$directions[$i].'">
                                                <input  name="phone" type="hidden" value="'.$phones[$i].'">
                                                <input type="submit" id="submit" value="Editar" name="edit_cinema" class="primary" />
                                            </form> 
                                        </li> 
                                        <li> 
                                            <form method="post" action="index.php?state=mc">
                                                <input  name="id" type="hidden" value="'.$ids[$i].'">
                                                <input  name="name" type="hidden" value="'.$names[$i].'">
                                                <input  name="direction" type="hidden" value="'.$directions[$i].'">
                                                <input  name="phone" type="hidden" value="'.$phones[$i].'">
                                                <input type="submit" id="submit" value="Eliminar" name="delete_cinema" class="primary" />
                                            </form> 
                                        </li> 
                                </div>
                                '; 
                                $parity = ($parity == "odd") ? "even" : "odd";
                        } 
                    $reply .=' </div>';
                break;
            
            default:
                break;
         }
        }
        return $reply;
    }

    function print_promotions(){
        $reply = "";

        //List of the cinemas:
        require_once(__DIR__.'/includes/promotion_dao.php');

        $prefix= $this->get_prefix();

        $promotion = new Promotion_DAO("complucine");
        $promotions = $promotion->allPromotionData();
        $ids = array();
        $tittles = array();
        $descriptions = array();
        $codes = array();
        $isActive = array();

        if(is_array($promotions)){
            foreach($promotions as $key => $value){
                $ids[$key] = $value->getId();
                $tittles[$key] = $value->getTittle();
                $descriptions[$key] = $value->getDescription();
                $codes[$key] = $value->getCode();
                if($value->getActive()){
                    $isActives[$key] = "ACTIVA";
                } else {
                    $isActives[$key] = "CADUCADA";
                }
            }
        }

        switch($this->page){
            case "Promociones":
                for($i = 0; $i < count($promotions); $i++){
                    if($i%2 === 0){
                        if($i != 0) $reply .= "</div>
                    ";
                        $reply .= "<div class='column side'>
                        ";
                    }
                    else{
                        if($i != 0) $reply .= "</div>
                    ";
                    $reply .= "<div class='column middle'>
                        ";
                    }
                    $reply .= "<section id='".$tittles[$i]."'>
                            <div class='zoom'>
                                <div class='code promo'>
                                    <div class='image'><img src='".$prefix."img/promos/".str_replace(' ', '_', strtolower($tittles[$i])).".jpg' alt='".$tittles[$i]."' /></div>
                                    <h2>".$tittles[$i]."</h2>
                                    <hr />
                                    <div class='blockquote'>
                                        <p>".$descriptions[$i]."</p>
                                    </div>
                                    <li>Código: ".$codes[$i]."</li>
                                    <li>Estado: ".$isActives[$i]."</li>
                                </div>
                            </div>
                        </section>
                    ";
                }
                $reply .= "</div>\n";
                break;
            default:
                break;
        }

        return $reply;
    }

    //Print session MSG:
    function print_msg() {
        if(isset($_SESSION['message'])){
            echo "<div>".$_SESSION['message']."</div>";
            unset($_SESSION['message']);
        }
    }

    //Print generic Footer:
    function print_footer(){
        $prefix = $this->prefix;
        $page = $this->page;
        
        if(!isset($_SESSION["css"]) || $_SESSION["css"] === "main.css"){
            $css = "{$prefix}assets/css/highContrast.css";
            $nameCSS = "Alto Contraste";
        } else {
            $css = "{$prefix}assets/css/main.css";
            $nameCSS = "Contraste Normal";
        }
        

        echo"<footer>
            <div class='footer'>
                <p>© Práctica Final | Sistemas Web 2021 </p>
            </div>
            <span class='go-up'>&#x1F51D</span>
            <a href='{$prefix}fdicines/about_us/'>Sobre FDI-Cines</a> |
            <a href='{$prefix}fdicines/terms_conditions/'>Términos de uso</a> |
            <a href='{$prefix}cinemas/'>Nuestros cines</a> |
            <a href='{$prefix}contacto/'>Contacto</a> |
            <button id='cssChange' onclick=\"cambiarCSS('$css');\">$nameCSS</button>
        </footer>\n";
    }

    //Print JS scripts:
    function print_scripts(){
        $prefix = $this->prefix;
        $page = $this->page;

        echo"<script type='text/javascript' src='{$prefix}assets/js/jquery-3.2.1.min.js'></script>
        <script type='text/javascript' src='{$prefix}assets/js/cambiarCSS.js'></script>
        <script type='text/javascript' src='{$prefix}assets/js/checkForms.js'></script>
        <script type='text/javascript' src='{$prefix}assets/js/goUp.js'></script>
        ";
        if($page === "FDI-Cines") echo"<script type='text/javascript' src='{$prefix}assets/js/promotions.js'></script>\n";
        if($page === "Panel de Usuario") echo"<script type='text/javascript' src='{$prefix}assets/js/deleteConfirm.js'></script>\n";
        if($page === "Comprar Entrada") echo"<script type='text/javascript' src='{$prefix}assets/js/selectTicket.js'></script>
        <script type='text/javascript' src='{$prefix}assets/js/checkPay.js'></script>
        <script type='text/javascript' src='{$prefix}assets/js/goBack.js'></script>\n";
        if($page === "Panel de Gerente") echo"<script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>
        <script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
        <script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js'></script>
        <script type='text/javascript' src='{$prefix}assets/js/sessionCalendar.js'></script>
        <script type='text/javascript' src='{$prefix}assets/js/sessionFormProcess.js'></script>\n";
    }

    }
?>