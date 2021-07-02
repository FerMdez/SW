<?php
    /**
    * Connection parameters to the DB.
    */
    define('BD_HOST', '');
    define('BD_NAME', '');
    define('BD_USER', '');
    define('BD_PASS', '');

    /*
    * Configuration parameters used to generate URLs and file paths in the application
    */
    define('ROUTE_APP', '/'); //Change if it´s necessary.
    define('RAIZ_APP', __DIR__);

    /**
    * Image files directory.
    */
    define('FILMS_DIR', RAIZ_APP.'/img/films/');
    define('FILMS_DIR_PROTECTED', dirname(RAIZ_APP).'/img/films/tmp/');
    define('USER_PICS',  ROUTE_APP.'img/users/');

    /**
     * Allowed extensions for image files.
     */
    $ALLOWED_EXTENSIONS = array('gif','jpg','jpe','jpeg','png');

    /**
    * Utf-8 support settings, location (language and country) and time zone.
    */
    ini_set('default_charset', 'UTF-8');
    setLocale(LC_ALL, 'es_ES.UTF.8');
    date_default_timezone_set('Europe/Madrid');

    //Start session:
    session_start();

    //HTML template:
    require_once('template.php');
    $template = new Template();
    $prefix = $template->get_prefix();

    /**
     * Initialize the application:
     */
    include_once($prefix.'assets/php/dao.php');
    require_once('aplication.php');
    $app = Aplicacion::getSingleton();
    $app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));

    /**
     * @see http://php.net/manual/en/function.register-shutdown-function.php
     * @see http://php.net/manual/en/language.types.callable.php
     */
    register_shutdown_function(array($app, 'shutdown'));
?>
