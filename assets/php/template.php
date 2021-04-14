<?php
    class Template {

    //Attributes:
    public $page;           //Page Name.
    public $prefix;         //Page prefix.

    public $session;        //"Iniciar Sesión" (if user isn´t logged in), "Cerrar Sesión" (otherwise).
    public $session_route;  //"login/" (if user isn´t logged in), "logout/" (otherwise).
    public $panel;          //Button to access the user's dashboard (only displayed if logged in).
    public $user_route;     //Route of the panel (depends on the type of user).

    //Constructor:
    function __construct(){
        $this->page = $_SERVER['PHP_SELF']; //Page that instantiates the template.
        $this->prefix = '../';              //Default prefix.

        $this->set_page_prefix();           //Assigns the name and prefix of the page.

        $this->session = 'Iniciar Sesión';  //Default, the session has not started.
        $this->session_route = 'login/';    //Default, the session has not started.
        $this->panel = '';                  //Default, the session has not started.
        $this->user_route = 'panel_user/';  //Default, the type of client is user.
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
            case strpos($this->page, 'cinemas'): $this->page = 'Nuestros Cines'; break;
            case strpos($this->page, 'about_us'): $this->page = 'Sobre FDI-Cines'; $this->prefix = '../../'; break;
            case strpos($this->page, 'terms'): $this->page = 'Términos y Condiciones'; $this->prefix = '../../'; break;
            case strpos($this->page, 'detalles'): $this->page = 'Detalles'; $this->prefix = '../../'; break;
            case strpos($this->page, 'bocetos'): $this->page = 'Bocetos'; $this->prefix = '../../'; break;
            case strpos($this->page, 'miembros'): $this->page = 'Miembros'; $this->prefix = '../../'; break;
            case strpos($this->page, 'planificacion'): $this->page = 'Planificación'; $this->prefix = '../../'; break;
            case strpos($this->page, 'contacto'): $this->page = 'Contacto'; break;
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

        echo"<head>
        <title>CompluCine | {$page}</title>
        <meta charset='utf-8' />
        <link id='estilo' rel='stylesheet' type='text/css' href='{$prefix}assets/css/main.css'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='icon' href='{$prefix}img/favicon.png' />
    </head>\n";
    }

    //Print generic Header:
    function print_header(){
        $page = $this->page;
        $prefix = $this->prefix;
        $session = $this->session;
        $session_route =$this->session_route;
        $user_route = $this->user_route;
        $panel =$this->panel;

        if(isset($_SESSION["nombre"])){
            if($_SESSION["rol"] == "admin") $user_route = 'panel_admin/';
            else if($_SESSION["rol"] == "manager") $user_route = 'panel_manager/';
            $panel = "<a href='{$prefix}{$user_route}'><li>Mi Panel</li></a>";
            $session = 'Cerrar Sesión';
            $session_route = 'logout/';
        }
        
        echo"<div class='header'>
            <a href='{$prefix}'><img src='{$prefix}img/favicon2.png' alt='favicon' /> CompluCine</a> | {$page}
            <div class='menu'>
                <nav>
                    <a href='{$prefix}{$session_route}'><li>{$session}</li></a>
                    {$panel}
                    <li>Menú
                        <ul>
                            <a href='{$prefix}'><li>Inicio</li></a>
                            <a href='{$prefix}showtimes/'><li>Cartelera</li></a>
                            <a href='{$prefix}cinemas/'><li>Nuestros Cines</li></a>
                            <a href='{$prefix}fdicines/miembros/'><li>Quiénes somos</li></a>
                            <a href='{$prefix}contacto/'><li>Contacto</li></a>
                        <ul>
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
    function print_main(){
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
        echo"<div class='main'>
            <div class='image'><a href='{$prefix}'><img src='{$prefix}img/logo_trasparente.png' alt='logo_FDI-Cines' /></a></div>
            {$sub_header}
            <h1>{$page}</h1>
            <hr />
        </div>\n";
    }

    //Print generic Footer:
    function print_footer(){
        //$page = $this->page;
        $prefix = $this->prefix;

        echo"<footer>
            <div class='footer'>
                <p>© Práctica 2 | Sistemas Web 2021 </p>
            </div>
            <a href='{$prefix}fdicines/about_us/'>Sobre FDI-Cines</a> |
            <a href='{$prefix}fdicines/terms_conditions/'>Términos y condiciones</a> |
            <a href='{$prefix}cinemas/'>Nuestros cines</a> |
            <a href='{$prefix}contacto/'>Contacto</a>
        </footer>\n";
    }

    //Print session MSG:
    function print_msg() {
        if(isset($_SESSION['message'])){
            echo "<div>".$_SESSION['message']."</div>";
            unset($_SESSION['message']);
        }
    }

    }
?>