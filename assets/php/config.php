<?php
    /**
    * Connection parameters to the DB.
    */
    define('BD_HOST', 'localhost');
    define('BD_NAME', 'complucine');
    define('BD_USER', 'sw');
    define('BD_PASS', '_admin_');

    /*
    * Configuration parameters used to generate URLs and file paths in the application
    */
    define('ROUTE_APP', '/'); //Change if it´s necessary.

    /**
    * Image files directory.
    */
    define('FILMS_DIR', ROUTE_APP.'img/films');

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
    require_once('aplication.php');
    $app = Aplicacion::getSingleton();
    $app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));

    /**
     * @see http://php.net/manual/en/function.register-shutdown-function.php
     * @see http://php.net/manual/en/language.types.callable.php
     */
    register_shutdown_function(array($app, 'shutdown'));

    //Depuración (BORRAR):
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
